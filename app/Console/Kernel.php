<?php

namespace App\Console;

use App\Models\GeneralSetting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ColabUpdate::class,
        Commands\DailyReport::class,
        Commands\SpinnerResetForm::class,
        Commands\MonthlyTasks::class,
        Commands\SendMailToBetween::class,
        Commands\SpinnerMailToAboveLimit::class,
        Commands\GamersGamesMail::class,
         Commands\SpinnerWinnerCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      
        //  $schedule->command('SpinnerWinnerCron:cron')
        //  ->everyMinute();
         $schedule->command('colabUpdate:cron')
         ->daily();
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
