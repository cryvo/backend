<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

protected function schedule(Schedule $schedule)
{
    $schedule->command('escrow:auto-settle')->everyMinute();
}
protected function schedule(Schedule $schedule)
{
    // run every second (or every minute if your host doesn’t allow every-second)
    $schedule->command('crybot:scan')->everyMinute();
}
$interval = Setting::get('crybot.schedule_interval', 'everyMinute');
$schedule->command('crybot:scan')
         ->{$interval}()        // dynamic method call
         ->withoutOverlapping();




class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Fetch the interval setting (e.g. "everyMinute", "hourly", or a CRON string)
        $interval = DB::table('settings')
            ->where('key', 'crybot.schedule_interval')
            ->value('value') 
            ?? 'everyMinute';

        // If it's one of the built-in Schedule methods, call it directly...
        $builtIns = ['everyMinute','everyFiveMinutes','everyTenMinutes','hourly','daily','weekly'];
        if (in_array($interval, $builtIns, true)) {
            $schedule
                ->command('crybot:scan')
                ->{$interval}()
                ->withoutOverlapping();
        }
        // Otherwise assume it's a CRON expression
        else {
            $schedule
                ->command('crybot:scan')
                ->cron($interval)
                ->withoutOverlapping();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
