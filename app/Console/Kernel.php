<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        Commands\GenerateRecurringSchedules::class,
    ];

   protected function schedule(Schedule $schedule)
    {
        // Hapus baris 'schedules:generate' yang lama karena udah diganti
        $schedule->command('bookings:cancel-expired')->everyMinute();
        $schedule->command('schedules:generate-recurring')->daily();
    }

}
