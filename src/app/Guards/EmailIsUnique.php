<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */
namespace LaravelFrance\Guards;

use LaravelFrance\Exceptions\EmailAlreadyTaken;
use LaravelFrance\User;

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
        $email = trim($this->get('email', $args));

        $exists = User::whereRaw('LOWER(email) = LOWER(?)', [$email])->exists();

        if (!$exists) return true;

        throw new EmailAlreadyTaken('email_already_taken', $email);
    }
}
