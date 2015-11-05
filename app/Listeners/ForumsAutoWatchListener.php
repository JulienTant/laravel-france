<?php

namespace LaravelFrance\Listeners;

use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelFrance\Events\ForumsTopicPosted;
use LaravelFrance\ForumsWatch;

class ForumsAutoWatchListener
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
     * @param ForumsTopicPosted $event
     */
    public function whenForumsTopicPosted(ForumsTopicPosted $event)
    {
        $topic = $event->getTopic();
        $user = $topic->user;

        if ($user->getForumsPreferencesItem('watch_created_topic')) {
            ForumsWatch::createWatcher($user, $topic);
        }
    }

    /**
     * @param ForumsMessagePostedOnForumsTopic $event
     */
    public function whenForumsMessagePostedOnForumsTopic(ForumsMessagePostedOnForumsTopic $event)
    {
        $topic = $event->getTopic();
        $user = $event->getMessage()->user;

        if ($user->getForumsPreferencesItem('watch_reply_topic')) {
            $forumsWatchExists = ForumsWatch::whereUserId($user->id)->whereForumsTopicId($topic->id)->exists();

            if (!$forumsWatchExists) {
                ForumsWatch::createWatcher($user, $topic);
            }
        }
    }
}
