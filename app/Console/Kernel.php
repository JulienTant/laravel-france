<?php

namespace LaravelFrance\Console;

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
        \LaravelFrance\Console\Commands\Inspire::class,
        \LaravelFrance\Console\Commands\RebuildElasticSearchIndexes::class,
        \LaravelFrance\Console\Commands\RecountMessagesOfForum::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();
    }
}
