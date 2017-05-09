<?php

namespace DexBarrett\Console;

use Illuminate\Console\Scheduling\Schedule;
use DexBarrett\Console\Commands\CreateUser;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \DexBarrett\Console\Commands\Inspire::class,
        CreateUser::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:clean')->weekly()->at('03:00');
        $schedule->command('backup:run')->weekly()->at('04:00');
    }
}
