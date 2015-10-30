<?php

namespace LaravelFrance\Providers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Str;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsMessage;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Group;
use LaravelFrance\User;

class AuthServiceProvider extends ServiceProvider
{

    static $noSuperPowersFor = ['forums.can_mark_as_solve'];
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
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        /** @var \Illuminate\Auth\Access\Gate $gate */
        $this->giveAdminsSuperPower($gate);

        $this->defineForumsRules($gate);

        $this->defineProfileRules($gate);
    }

    /**
     * @param GateContract $gate
     */
    private function giveAdminsSuperPower(GateContract $gate)
    {
        $gate->before(function (User $user, $ability) {
            // SuperAdmin
            if (!in_array($ability, self::$noSuperPowersFor) && in_array(Group::SUPERADMIN, $user->groups)) {
                return true;
            }
        });
    }

    /**
     * @param GateContract $gate
     */
    private function defineForumsRules(GateContract $gate)
    {
        $gate->before(function (User $user, $ability) {
            if (!in_array($ability, self::$noSuperPowersFor) && str_is('forums.*', $ability) && in_array(Group::FORUMS_MODERATOR, $user->groups)) {
                return true;
            }
        });

        $gate->define('forums.can_create_topic', function (User $user, ForumsCategory $category = null) {
            return true;
        });

        $gate->define('forums.can_reply_to_topic', function (User $user, ForumsTopic $topic) {
            return true;
        });

        $gate->define('forums.can_edit_message', function (User $user, ForumsMessage $message) {
            // is the actual user is the author
            return $message->user_id == $user->id;
        });

        $gate->define('forums.can_remove_message', function (User $user, ForumsMessage $message) {
            // the actual user is the author
            if ($message->user_id != $user->id) {
                return false;
            }

            if ($message->forumsTopic->forumsMessages()->count() > 1) {
                return false;
            }

            return true;
        });

        $gate->define('forums.can_mark_as_solve', function (User $user, ForumsMessage $message) {

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

    private function defineProfileRules(Gate $gate)
    {
        $gate->define('profile.can_change_username', function () {
            return true;
        });

        $gate->define('profile.can_change_email', function () {
            return true;
        });
    }
}
