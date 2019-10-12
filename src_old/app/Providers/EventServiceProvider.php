<?php

namespace LaravelFranceOld\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelFranceOld\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFranceOld\Events\ForumsMessageWasDeleted;
use LaravelFranceOld\Events\ForumsTopicPosted;

/**
 * Class EventServiceProvider
 * @package LaravelFranceOld\Providers
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
            'LaravelFranceOld\Listeners\ManageNbMessagesOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFranceOld\Listeners\ManageLastMessageOnTopic@whenForumsMessagePostedOnForumsTopic',
            'LaravelFranceOld\Listeners\ManageNbMessagesOnUser@whenForumsMessagePostedOnForumsTopic',
            'LaravelFranceOld\Listeners\ForumsAutoWatchListener@whenForumsMessagePostedOnForumsTopic',
            'LaravelFranceOld\Listeners\SendEmailToWatchersWhenForumsMessagesPostedListener',
            'LaravelFranceOld\Listeners\UpdateWatchersStatus@whenForumsMessagePostedOnForumsTopic',
        ],
        ForumsMessageWasDeleted::class => [
            'LaravelFranceOld\Listeners\ManageNbMessagesOnTopic@whenForumsMessageWasDeleted',
            'LaravelFranceOld\Listeners\ManageLastMessageOnTopic@whenForumsMessageWasDeleted',
            'LaravelFranceOld\Listeners\ManageNbMessagesOnUser@whenForumsMessageWasDeleted',
        ],
        ForumsTopicPosted::class => [
            'LaravelFranceOld\Listeners\ForumsAutoWatchListener@whenForumsTopicPosted',
            'LaravelFranceOld\Listeners\SlackForumsWatcher@whenForumsTopicPosted',
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
