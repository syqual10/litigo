<?php

namespace SQ10\Console;

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
        // php artisan make:command RecordarCitacion
        // php artisan make:mail Notificacion
        'SQ10\Console\Commands\RecordarAgenda',
        'SQ10\Console\Commands\RecordarAntesAgenda',
        'SQ10\Console\Commands\RecordarTutelaSms',
        'SQ10\Console\Commands\RecordarTutela',
        'SQ10\Console\Commands\RecordarNoLeidos'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
