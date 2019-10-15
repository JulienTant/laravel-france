<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Guards;


use Arr;
use Exception;

abstract class Guard
{
    /**
     * Handle the Guard
     *
     * @param array $args
     * @return bool
     */
    abstract public function check(array $args);

    /**
     * Get an argument from the `args` array
     *
     * @param string $key
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    protected function get($key, $args)
    {
        $arg = Arr::get($args, $key);

        if ($arg) return $arg;

        throw new Exception(sprintf('%s was not found in the `args` array', $key));
    }
}
