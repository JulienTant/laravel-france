<?php

namespace LaravelFrance\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelFrance\ForumsTopic;
use LaravelFrance\User;

/**
 * Class ForumsTopicPosted
 * @package LaravelFrance\Events
 */
class ForumsTopicPosted
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
     * Create a new event instance.
     *
     * @param User $user
     * @param ForumsTopic $topic
     */
    public function __construct(User $user, ForumsTopic $topic)
    {
        $this->user = $user;
        $this->topic = $topic;
    }

    /**
     * @return ForumsTopic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
