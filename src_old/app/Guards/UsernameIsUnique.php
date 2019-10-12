<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Guards;


use LaravelFranceOld\Exceptions\UsernameAlreadyTaken;
use LaravelFranceOld\User;

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
