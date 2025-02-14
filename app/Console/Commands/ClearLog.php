<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;
use App\Models\User;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            $this->get_lines($logFile);
            file_put_contents($logFile, '');
            $this->info('Log file has been cleared');

            $user = User::where('username', 'like', '%admin%')->first();
            Activity::create([
                'action' => 'Log | Clear',
                'description' => 'Log file has been cleared',
                'user_id' => $user->id,
            ]);
        } else {
            $this->info('Log file does not exist');
        }
        // if (File::exists($logFile)) {
        //     File::put($logFile, '');
        //     $this->info('Log file has been cleared');
        // } else {
        //     $this->info('Log file does not exist');
        // }
        return 0;
    }

    private function get_lines($logFile)
    {
        $user = User::where('username', 'like', '%admin%')->first();
        $date = date('Y-m-d'); // Example: filter by today's date
        $handle = fopen($logFile, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // Check if the line starts with the specified date
                if (preg_match("/^\[$date/", $line)) {
                    // Process the line (e.g., print it, store it in the database, etc.)
                    // $this->info($line);
                    $first180 = substr($line, 0, 180);
                    Activity::create([
                        'action' => 'Command : Clear Log | Line Error',
                        'description' => $first180,
                        'user_id' => $user->id,
                    ]);
                }
            }
            fclose($handle);
        } else {
            $this->error('Unable to open log file.');
        }
    }
}
