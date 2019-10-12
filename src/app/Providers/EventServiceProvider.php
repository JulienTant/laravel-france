<?php

namespace LaravelFrance\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\Events\ForumsTopicPosted;

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
            'LaravelFrance\Listeners\SendEmailToWatchersWhenForumsMessagesPostedListener',
            'LaravelFrance\Listeners\UpdateWatchersStatus@whenForumsMessagePostedOnForumsTopic',
        ],
        ForumsMessageWasDeleted::class => [
            'LaravelFrance\Listeners\ManageNbMessagesOnTopic@whenForumsMessageWasDeleted',
            'LaravelFrance\Listeners\ManageLastMessageOnTopic@whenForumsMessageWasDeleted',
            'LaravelFrance\Listeners\ManageNbMessagesOnUser@whenForumsMessageWasDeleted',
        ],
        ForumsTopicPosted::class => [
            'LaravelFrance\Listeners\ForumsAutoWatchListener@whenForumsTopicPosted',
            'LaravelFrance\Listeners\SlackForumsWatcher@whenForumsTopicPosted',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
