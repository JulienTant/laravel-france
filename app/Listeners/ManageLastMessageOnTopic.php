<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\ForumsTopic;

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

    /**
     * @param ForumsMessageWasDeleted $event
     */
    public function whenForumsMessageWasDeleted(ForumsMessageWasDeleted $event)
    {
        if (!$event->getUpdateTopic()) return;

        $topic = ForumsTopic::find($event->getMessage()->forums_topic_id);
        $message = $topic->forumsMessages()->orderBy('created_at', 'DESC')->first();
        if ($message) {
            $topic->lastMessage()->associate($message);
        } else {
            $topic->lastMessage()->dissociate();
        }

        $topic->save();
    }
}
