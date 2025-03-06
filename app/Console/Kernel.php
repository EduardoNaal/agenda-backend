<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define el programador de comandos de la aplicación.
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecuta el envío de recordatorios cada minuto
        $schedule->command('reminders:send')->everyMinute();
    }

    /**
     * Registra los comandos de la aplicación.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
