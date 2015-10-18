<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManageLastMessageOnTopic
{
    /**
     * @param ForumsMessagePostedOnForumsTopic $event
     */
    public function whenForumsMessagePostedOnForumsTopic(ForumsMessagePostedOnForumsTopic $event)
    {
        $topic = $event->getTopic();
        $topic->lastMessage()->associate($event->getMessage());

        $topic->save();
    }
}
