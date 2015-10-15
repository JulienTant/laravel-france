<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Guards;


use LaravelFrance\Exceptions\UsernameAlreadyTaken;
use LaravelFrance\User;

class UsernameIsUnique extends Guard
{

    /**
     * Handle the Guard
     *
     * @param array $args
     * @return bool
     */
    public function check(array $args)
    {
        $username = $this->get('username', $args);

        $exists = User::whereRaw('LOWER(username) = LOWER(?)', [$username])->exists();

        if (!$exists) return true;

        throw new UsernameAlreadyTaken('username_already_taken', $username);


    }
}