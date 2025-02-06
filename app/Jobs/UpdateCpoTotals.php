<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Models\Cpo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class UpdateCpoTotals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $cpo;
    public $user;
    public $ip_address;
    public function __construct(Cpo $cpo, $user = null, $ip_address = null)
    {
        $this->cpo = $cpo;
        $this->user = $user;
        $this->ip_address = $ip_address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user ?? User::where('username', 'like', '%admin%')->first();

        $cpo = $this->cpo;
        // $cpo->total = $cpo->lines->sum('total');
        $cpo->total_amount = $cpo->lines->map(function ($line) {
            return $line->price * $line->qty_returned;
        })->sum();
        $cpo->total_qty_returned = $cpo->lines->sum('qty_returned');
        $cpo->save();

        $cposNullTotal = Cpo::whereNull('total_amount')->get();
        $cposNullTotalCount = $cposNullTotal->count();
        foreach ($cposNullTotal as $cpoNull) {
            $cpoNull->total_amount = $cpoNull->lines->map(function ($line) {
                return $line->price * $line->qty_returned;
            })->sum();
            $cpoNull->total_qty_returned = $cpoNull->lines->sum('qty_returned');
            $cpoNull->save();
        }

        Activity::create([
            'action' => 'Job | Updated CPO Totals',
            'description' => 'CPO Totals updated for: ' . $cpo->formatted_id . ' | Updated Other CPOs: ' . $cposNullTotalCount,
            'user_id' => $user->id,
            'action_by' => $user->name,
            'ip_address' =>  $this->ip_address
        ]);
    }
}
