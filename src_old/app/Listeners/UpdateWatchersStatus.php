<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\ForumsWatch;

class UpdateWatchersStatus
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ForumsMessagePostedOnForumsTopic  $event
     * @return void
     */
    public function whenForumsMessagePostedOnForumsTopic(ForumsMessagePostedOnForumsTopic $event)
    {
        $watchers = ForumsWatch::active()->whereForumsTopicId($event->getTopic()->id)->get();
        foreach ($watchers as $watcher) {
            /** @var ForumsWatch $watcher */
            $watcher->noMoreUpToDate($event->getMessage());
            $watcher->save();
        }
    }
}
