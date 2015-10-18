<?php

namespace LaravelFrance\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package LaravelFrance\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'LaravelFrance\Events\ForumsTopicPosted' => [],
        'LaravelFrance\Events\ForumsMessagePostedOnForumsTopic' => [
            'LaravelFrance\Listeners\ManageNbMessagesOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFrance\Listeners\ManageLastMessageOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFrance\Listeners\ManageNbMessagesOnUser@whenForumsMessagePostedOnForumsTopic',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
