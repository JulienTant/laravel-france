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
 * LaravelFrance\ForumsWatch
 *
 * @property int $id
 * @property int $forums_topic_id
 * @property int $user_id
 * @property int $is_up_to_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $still_watching
 * @property int|null $first_unread_message_id
 * @property-read \LaravelFrance\ForumsMessage|null $firstUnreadMessage
 * @property-read \LaravelFrance\ForumsTopic $forumsTopic
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch active()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch mailable()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereFirstUnreadMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereForumsTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereIsUpToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereStillWatching($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsWatch whereUserId($value)
 */
	class ForumsWatch extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\OAuth
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $uid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth github()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth google()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth twitter()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\OAuth whereUserId($value)
 */
	class OAuth extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsMessage
 *
 * @property int $id
 * @property int $forums_topic_id
 * @property int $user_id
 * @property string $markdown
 * @property int $solve_topic
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \LaravelFrance\ForumsTopic $forumsTopic
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereForumsTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereSolveTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsMessage whereUserId($value)
 */
	class ForumsMessage extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsTopic
 *
 * @property int $id
 * @property int $forums_category_id
 * @property int $user_id
 * @property int $sticky
 * @property string $title
 * @property string $slug
 * @property int $solved
 * @property int|null $solved_by
 * @property int|null $last_message_id
 * @property int $nb_messages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \LaravelFrance\ForumsMessage $firstMessage
 * @property-read \LaravelFrance\ForumsCategory $forumsCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\ForumsMessage[] $forumsMessages
 * @property-read int|null $forums_messages_count
 * @property-read \LaravelFrance\ForumsMessage|null $lastMessage
 * @property-read \LaravelFrance\ForumsMessage|null $solvedBy
 * @property-read \LaravelFrance\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic forListing()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereForumsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereNbMessages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereSolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereSolvedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsTopic whereUserId($value)
 */
	class ForumsTopic extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\ForumsCategory
 *
 * @property int $id
 * @property int $order
 * @property string $name
 * @property string $slug
 * @property string $background_color
 * @property string $font_color
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereFontColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\ForumsCategory whereUpdatedAt($value)
 */
	class ForumsCategory extends \Eloquent {}
}

namespace LaravelFrance{
/**
 * LaravelFrance\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property array $groups
 * @property array $forums_preferences
 * @property int $nb_messages
 * @property string $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereForumsPreferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereNbMessages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\LaravelFrance\User whereUsername($value)
 */
	class User extends \Eloquent {}
}

