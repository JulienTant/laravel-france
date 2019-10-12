<?php

namespace LaravelFrance\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelFrance\ForumsMessage;
use LaravelFrance\ForumsTopic;
use LaravelFrance\User;

/**
 * Class ForumsMessagePostedOnForumsTopic
 * @package LaravelFrance\Events
 */
class ForumsMessagePostedOnForumsTopic
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    private $user;
    /**
     * @var ForumsTopic
     */
    private $topic;
    /**
     * @var ForumsMessage
     */
    private $message;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param ForumsTopic $topic
     * @param ForumsMessage $message
     */
    public function __construct(User $user, ForumsTopic $topic, ForumsMessage $message)
    {
        $this->user = $user;
        $this->topic = $topic;
        $this->message = $message;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ForumsTopic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @return ForumsMessage
     */
    public function getMessage()
    {
        return $this->message;
    }
}
