<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;

class Group
{
    const SUPERADMIN = 'superadmin';
    const FORUMS_MODERATOR = 'forums_moderator';

    public static function all()
    {
        return array_flip(with(new \ReflectionClass(__CLASS__))->getConstants());
    }
}
