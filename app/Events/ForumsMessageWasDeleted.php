<?php

namespace LaravelFrance\Events;

use LaravelFrance\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use LaravelFrance\ForumsMessage;

class ForumsMessageWasDeleted extends Event
{
    use SerializesModels;
    /**
     * @var ForumsMessage
     */
    private $message;

    /**
     * @var bool
     */
    private $updateTopic;

    /**
     * Create a new event instance.
     *
     * @param ForumsMessage $message
     * @param bool $updateTopic
     */
    public function __construct(ForumsMessage $message, $updateTopic = true)
    {
        $this->message = $message;
        $this->updateTopic = $updateTopic;
    }

    /**
     * @return ForumsMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return boolean
     */
    public function getUpdateTopic()
    {
        return $this->updateTopic;
    }
}
