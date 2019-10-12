<?php

namespace LaravelFrance\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelFrance\ForumsMessage;

class ForumsMessageWasDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
