<?php

namespace LaravelFrance\Events;

use Illuminate\Queue\SerializesModels;
use LaravelFrance\ForumsMessage;
use LaravelFrance\ForumsTopic;

class ForumsTopicWasSolved extends Event
{
    use SerializesModels;


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
     * @param ForumsTopic $topic
     * @param ForumsMessage $message
     */
    public function __construct(ForumsTopic $topic, ForumsMessage $message)
    {
        $this->topic = $topic;
        $this->message = $message;
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
