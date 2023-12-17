<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //activar si es que el servidor permite comandos artisan 
        //su coomand se llama UpdateIngresoEgresoDaily
        
        /* $schedule->command('app:update-ingreso-egreso-daily')
        ->dailyAt('23:59'); // Ejecutar justo antes de medianoche */
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
