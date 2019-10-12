<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Guards;


trait Guards
{
    /**
     * Run the Guards
     *
     * @param array $guards
     * @param array $args
     * @return void
     */
    public function guard(array $guards, array $args)
    {
        array_map(function ($guard) use ($args) {
            /** @var Guard $guard */
            app($guard)->check($args);
        }, $guards);
    }

}
