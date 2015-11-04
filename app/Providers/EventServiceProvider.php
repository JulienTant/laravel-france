<?php

namespace LaravelFrance\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\Events\ForumsTopicPosted;

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
        ForumsMessagePostedOnForumsTopic::class => [
            'LaravelFrance\Listeners\ManageNbMessagesOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFrance\Listeners\ManageLastMessageOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFrance\Listeners\ManageNbMessagesOnUser@whenForumsMessagePostedOnForumsTopic',
            'LaravelFrance\Listeners\ForumsAutoWatchListener@whenForumsMessagePostedOnForumsTopic',
        ],
        ForumsMessageWasDeleted::class => [
            'LaravelFrance\Listeners\ManageNbMessagesOnTopic@whenForumsMessageWasDeleted',
            'LaravelFrance\Listeners\ManageLastMessageOnTopic@whenForumsMessageWasDeleted',
            'LaravelFrance\Listeners\ManageNbMessagesOnUser@whenForumsMessageWasDeleted',
        ],
        ForumsTopicPosted::class => [
            'LaravelFrance\Listeners\ForumsAutoWatchListener@whenForumsTopicPosted',
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
