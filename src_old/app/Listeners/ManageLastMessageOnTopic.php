<?php

namespace LaravelFranceOld\Listeners;

use LaravelFranceOld\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFranceOld\Events\ForumsMessageWasDeleted;
use LaravelFranceOld\ForumsTopic;

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
