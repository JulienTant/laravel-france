<?php

namespace LaravelFrance\Listeners;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\ForumsWatch;
use LaravelFrance\Mail\TopicUpdated;

class SendEmailToWatchersWhenForumsMessagesPostedListener
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param ForumsMessagePostedOnForumsTopic $event
     */
    public function handle(ForumsMessagePostedOnForumsTopic $event)
    {
        $topic = $event->getTopic();
        $poster = $event->getUser();

        /** @var ForumsWatch $watcher */
        foreach (ForumsWatch::mailable()->with('user')->whereForumsTopicId($topic->id)->where('user_id', '<>', $poster->id)->get() as $watcher) {
            if ($watcher->user->getForumsPreferencesItem('watch_new_reply_send_email') && filter_var($watcher->user->email, FILTER_VALIDATE_EMAIL)) {
                $this->mailer->queue(new TopicUpdated($topic, $poster, $event, $watcher->user));
            }
        }
    }
}
