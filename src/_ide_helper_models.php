<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace LaravelFrance{
/**
 * LaravelFrance\OAuth
 *
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth github()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth google()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth twitter()
 */
	class OAuth extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\ForumsMessage[] $forumsMessages
 * @property-read int|null $forums_messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\OAuth[] $oauth
 * @property-read int|null $oauth_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\ForumsWatch[] $watchedTopics
 * @property-read int|null $watched_topics_count
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User query()
 */
	class User extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory query()
 */
	class ForumsCategory extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsTopic
 *
 * @property-read \LaravelFrance\ForumsMessage $firstMessage
 * @property-read \LaravelFrance\ForumsCategory $forumsCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\ForumsMessage[] $forumsMessages
 * @property-read int|null $forums_messages_count
 * @property-read \LaravelFrance\ForumsMessage $lastMessage
 * @property-read \LaravelFrance\ForumsMessage $solvedBy
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic forListing()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic query()
 */
	class ForumsTopic extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsMessage
 *
 * @property-read \LaravelFrance\ForumsTopic $forumsTopic
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage query()
 */
	class ForumsMessage extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsWatch
 *
 * @property-read \LaravelFrance\ForumsMessage $firstUnreadMessage
 * @property-read \LaravelFrance\ForumsTopic $forumsTopic
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch active()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch mailable()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch query()
 */
	class ForumsWatch extends \Eloquent {}
}

