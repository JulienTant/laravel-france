<?php

namespace LaravelFranceOld\Events;

use Illuminate\Queue\SerializesModels;
use LaravelFranceOld\User;

class UserHasChangedHisUsername extends Event
{
    use SerializesModels;
    /**
     * @var User
     */
    private $user;
    /**
     * @var
     */
    private $oldUsername;
    /**
     * @var
     */
    private $newUsername;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param $oldUsername
     * @param $newUsername
     */
    public function __construct(User $user, $oldUsername, $newUsername)
    {
        //
        $this->user = $user;
        $this->oldUsername = $oldUsername;
        $this->newUsername = $newUsername;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getOldUsername()
    {
        return $this->oldUsername;
    }

    /**
     * @return mixed
     */
    public function getNewUsername()
    {
        return $this->newUsername;
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
