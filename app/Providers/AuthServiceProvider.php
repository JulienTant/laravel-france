<?php

namespace LaravelFrance\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Group;
use LaravelFrance\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        /** @var \Illuminate\Auth\Access\Gate $gate */
        $this->giveSuperAdminSuperPower($gate);

        $gate->define('forums.can_create_topic', function (User $user, ForumsCategory $category = null) {
            if (in_array(Group::FORUMS_MODERATOR, $user->groups)) {
                return true;
            }
            return true;
        });

        $gate->define('forums.can_reply_to_topic', function (User $user, ForumsTopic $topic) {
            if (in_array(Group::FORUMS_MODERATOR, $user->groups)) {
                return true;
            }
            return true;
        });
    }

    /**
     * @param GateContract $gate
     */
    private function giveSuperAdminSuperPower(GateContract $gate)
    {
        $gate->before(function (User $user) {
            if (in_array(Group::SUPERADMIN, $user->groups)) {
                return true;
            }
        });
    }
}
