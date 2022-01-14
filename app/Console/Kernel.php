<?php

namespace App\Console;

use App\Jobs\PortalSyncJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ShortSchedule\ShortSchedule;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            dispatch(new PortalSyncJob())->onQueue('lead_gen');
        })->everyMinute()->name('Lead generation initiated...')->withoutOverlapping(10);
    }

    /**
     * Define the application's command short schedule.
     *
     * @param ShortSchedule $shortSchedule
     * @return void
     */
    protected function shortSchedule(ShortSchedule $shortSchedule)
    {
        // this command will run every half a second
        $shortSchedule->command('sync:crm')->everySeconds(0.5)->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
