<?php

if (!function_exists('topic_link_for_listing')) {
    function topic_link_for_listing(\LaravelFranceOld\ForumsTopic $topic)
    {
        $auth = app(\Illuminate\Contracts\Auth\Guard::class);
        /** @var \LaravelFranceOld\User $user */
        $user = $auth->user();


        $url = route('forums.show-topic', [$topic->forumsCategory->slug, $topic->slug]);
        if ($user && $user->getForumsPreferencesItem('see_last_message')) {
            $url = route('forums.show-message', [$topic->last_message_id]);
        }

        return $url;
    }

}

