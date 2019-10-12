<?php

namespace LaravelFranceOld\Listeners;

use LaravelFranceOld\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFranceOld\Events\ForumsMessageWasDeleted;
use LaravelFranceOld\ForumsTopic;

class ManageNbMessagesOnTopic
{
    /**
     * @param ForumsMessagePostedOnForumsTopic $event
     */
    public function whenForumsMessagePostedOnForumsTopic(ForumsMessagePostedOnForumsTopic $event)
    {
        $topic = $event->getTopic();
        $topic->incrementNbMessages();
        $topic->save();
    }

    /**
     * @param ForumsMessageWasDeleted $event
     */
    public function whenForumsMessageWasDeleted(ForumsMessageWasDeleted $event)
    {
        if (!$event->getUpdateTopic()) return;

        $topic = ForumsTopic::find($event->getMessage()->forums_topic_id);
        $topic->decrementNbMessages();
        $topic->save();
    }
}
