<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Add this line to run your Crybot scan every minute:
        $schedule->command('crybot:scan')
                 ->everyMinute()
                 ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
protected $middlewareGroups = [
    'api' => [
        // ...
        \App\Http\Middleware\AuditLogMiddleware::class,
    ],
];
\App\Http\Middleware\PrometheusMiddleware::class,

protected $middlewareGroups = [
    'api' => [
        // … existing middleware …
        \App\Http\Middleware\TracingMiddleware::class,
    ],
];
