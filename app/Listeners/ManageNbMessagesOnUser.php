<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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


}
