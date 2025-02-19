<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Tournament15min::class,
        Commands\Tournament30min::class,
        Commands\Tournament3min::class,
        Commands\Tournament5min::class,
        Commands\Tournament8min::class,
        Commands\Tournament10min::class,
         Commands\Tournament1min::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron15min:cron')
        ->everyFifteenMinutes();
        $schedule->command('cron30min:cron')
        ->everyThirtyMinutes();
        $schedule->command('cron3min:cron')
        ->everyThreeMinutes();
        $schedule->command('cron5min:cron')
        ->everyFiveMinutes();
        $schedule->command('cron8min:cron')
        ->everyEightMinutes();
         $schedule->command('cron10min:cron')
        ->everyTenMinutes();
               $schedule->command('cron1min:cron')
        ->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
