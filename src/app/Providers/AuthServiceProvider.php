<?php

namespace LaravelFrance\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsMessage;
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
    protected $policies = [];

    static $noSuperPowersFor = ['forums.can_mark_as_solve'];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->giveAdminsSuperPower();

        $this->defineAdministrationRules();

        $this->defineForumsRules();

        $this->defineProfileRules();

    }


    private function giveAdminsSuperPower()
    {
        Gate::before(function (User $user, $ability) {
            // SuperAdmin
            if (!in_array($ability, self::$noSuperPowersFor) && in_array(Group::SUPERADMIN, $user->groups)) {
                return true;
            }
        });
    }


    private function defineForumsRules()
    {
        Gate::before(function (User $user, $ability) {
            if (!in_array($ability, self::$noSuperPowersFor) && str_is('forums.*', $ability) && in_array(Group::FORUMS_MODERATOR, $user->groups)) {
                return true;
            }
        });

        Gate::define('forums.can_create_topic', function (User $user, ForumsCategory $category = null) {
            return true;
        });

        Gate::define('forums.can_reply_to_topic', function (User $user, ForumsTopic $topic) {
            return true;
        });

        Gate::define('forums.can_edit_message', function (User $user, ForumsMessage $message) {
            // is the actual user is the author
            return $message->user_id == $user->id;
        });

        Gate::define('forums.can_remove_message', function (User $user, ForumsMessage $message) {
            // the actual user is the author
            if ($message->user_id != $user->id) {
                return false;
            }

            if ($message->forumsTopic->forumsMessages()->count() > 1) {
                return false;
            }

            return true;
        });

        Gate::define('forums.can_mark_as_solve', function (User $user, ForumsMessage $message) {
            if ($message->forumsTopic->solved) {
                return false;
            }

            if ($message->forumsTopic->user_id != $user->id) {
                return false;
            }

            if ($message->id == $message->forumsTopic->firstMessage->id) {
                return false;
            }

            return true;
        });
    }

    private function defineProfileRules()
    {
        Gate::define('profile.can_change_username', function () {
            return true;
        });

        Gate::define('profile.can_change_email', function () {
            return true;
        });
    }

    private function defineAdministrationRules()
    {
        Gate::define('admin.can_manage_users', function (User $user) {
            return in_array(Group::SUPERADMIN, $user->groups);
        });
    }
}
