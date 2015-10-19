<?php

namespace LaravelFrance\Providers;

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

            if ($message->forumTopic->forumsMessages()->count() > 1) {
                return false;
            }

            return true;
        });
    }

    /**
     * @param GateContract $gate
     */
    private function giveAdminsSuperPower(GateContract $gate)
    {
        $gate->before(function (User $user, $ability) {
            // SuperAdmin
            if (in_array(Group::SUPERADMIN, $user->groups)) {
                return true;
            }

            if (str_is('forums.*', $ability) && in_array(Group::FORUMS_MODERATOR, $user->groups)) {
                return true;
            }
        });
    }
}
