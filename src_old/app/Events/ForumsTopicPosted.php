<?php

namespace LaravelFranceOld\Events;

use Illuminate\Queue\SerializesModels;
use LaravelFranceOld\ForumsTopic;
use LaravelFranceOld\User;

/**
 * Class ForumsTopicPosted
 * @package LaravelFranceOld\Events
 */
class ForumsTopicPosted extends Event
{
    use SerializesModels;
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
