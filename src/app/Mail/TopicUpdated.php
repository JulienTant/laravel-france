<?php

namespace LaravelFrance\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\ForumsTopic;
use LaravelFrance\User;

class TopicUpdated extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var ForumsTopic
     */
    private $topic;
    /**
     * @var User
     */
    private $poster;
    /**
     * @var ForumsMessagePostedOnForumsTopic
     */
    private $event;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @param ForumsTopic $topic
     * @param User $poster
     * @param ForumsMessagePostedOnForumsTopic $event
     * @param User $user
     */
    public function __construct(ForumsTopic $topic, User $poster, ForumsMessagePostedOnForumsTopic $event, User $user)
    {
        $this->topic = $topic;
        $this->poster = $poster;
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('noreply@laravel.fr', 'Forums Laravel France');
        $this->subject('Nouvelle réponse sur le sujet ' . $this->topic->title);
        $this->to($this->user->email, $this->user->username);

        return $this->view('email.watch', [
            'topic_subject' => $this->topic->title,
            'author'        => $this->poster->username,
            'message_id'    => $this->event->getMessage()->id
        ]);
    }
}
