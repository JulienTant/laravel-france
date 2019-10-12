<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */
namespace LaravelFranceOld\Guards;

use LaravelFranceOld\Exceptions\EmailAlreadyTaken;
use LaravelFranceOld\User;

class EmailIsUnique extends Guard
{
    /**
     * Handle the Guard
     *
     * @param array $args
     * @return bool
     * @throws EmailAlreadyTaken
     */
    public function check(array $args)
    {
        $email = $this->get('email', $args);

        $exists = User::whereRaw('LOWER(email) = LOWER(?)', [$email])->exists();

        if (!$exists) return true;

        throw new EmailAlreadyTaken('email_already_taken', $email);
    }
}
