<?php

namespace App\Jobs;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $action;
    protected $description;
    protected $user_id;

    public function __construct(
        $action,
        $description,
        $user_id
    ) {
        $this->action = $action;
        $this->description = $description;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Activity::create([
            'action' => 'JOB | ' .  $this->action,
            'description' => $this->description,
            'user_id' => $this->user_id,
        ]);
    }
}
