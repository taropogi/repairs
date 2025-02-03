<?php

namespace App\Console;

use App\Models\Activity;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DeleteOldActivities;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();



        $schedule->job(new DeleteOldActivities)->everyFiveMinutes();

        // $schedule->call(function () {
        //     $user = User::where('username', 'like', '%admin%')->first();
        //     $query = DB::table('activities')->where('created_at', '<', now()->subDays(5));
        //     $affected = $query->count();

        //     $query->delete();
        //     Activity::create([
        //         'action' => 'Delete Activities',
        //         'description' => 'Deleted ' . $affected . '  activities older than 5 days',
        //         'user_id' => $user->id,
        //     ]);
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
