<?php

namespace LaravelFranceOld\Events;

use Illuminate\Queue\SerializesModels;
use LaravelFranceOld\User;

class UserForumsPreferencesWasChanged extends Event
{
    use SerializesModels;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
