<?php

namespace App\Console;

use App\Console\Commands\CreateDatabase;
use App\Console\Commands\DumpDatabase;
use App\Jobs\SendUserEmailJob;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        CreateDatabase::class,
        DumpDatabase::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            User::where('status', 'Active')->chunkById(100, function ($users) {
                    foreach ($users as $user) {
                        dispatch(new SendUserEmailJob($user));
                    }
                });
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
