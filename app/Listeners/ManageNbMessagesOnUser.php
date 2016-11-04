<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\User;

class ManageNbMessagesOnUser
{
    /**
     * @param ForumsMessagePostedOnForumsTopic $event
     */
    public function whenForumsMessagePostedOnForumsTopic(ForumsMessagePostedOnForumsTopic $event)
    {
        $user = $event->getUser();
        $user->incrementNbMessages();
        $user->save();
    }

    /**
     * @param ForumsMessageWasDeleted $event
     */
    public function whenForumsMessageWasDeleted(ForumsMessageWasDeleted $event)
    {
        $userId = $event->getMessage()->user_id;

        $user = User::find($userId);
        $user->decrementNbMessages();
        $user->save();
    }


}
