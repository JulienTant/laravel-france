<?php

namespace LaravelFranceOld\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class LocalEnvironment
{
    /**
     * @var Application
     */
    private $application;

    function __construct(Application $application)
    {
        $this->application = $application;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->application->environment() != "local") {
            return;
        }

        return $next($request);
    }
}
