<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;

class DeleteOldActivities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('username', 'like', '%admin%')->first();
        $query = DB::table('activities')->where('created_at', '<', now()->subDays(5));
        $affected = $query->count();

        $query->delete();
        Activity::create([
            'action' => 'Job | Delete Activities',
            'description' => 'Deleted ' . $affected . '  activities older than 5 days',
            'user_id' => $user->id,
        ]);
    }
}
