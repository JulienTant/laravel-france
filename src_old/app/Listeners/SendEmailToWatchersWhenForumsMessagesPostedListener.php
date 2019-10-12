<?php

namespace LaravelFranceOld\Listeners;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use LaravelFranceOld\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFranceOld\ForumsWatch;

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
                $user = $watcher->user;

                $parameters = [
                    'topic_subject' => $topic->title,
                    'author'        => $poster->username,
                    'message_id'    => $event->getMessage()->id
                ];


                $this->mailer->queue('forums.email.watch', $parameters, function (Message $message) use ($user, $parameters) {
                    $message->to($user->email, $user->username);
                    $message->from('noreply@laravel.fr', 'Forums Laravel France');
                    $message->subject('Nouvelle réponse sur le sujet ' . $parameters['topic_subject']);
                    return $message;
                });
            }
        }
    }
}
