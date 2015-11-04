<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;

/**
 * LaravelFrance\ForumsWatch
 *
 * @property integer $id
 * @property integer $forums_topic_id
 * @property integer $user_id
 * @property boolean $is_up_to_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read ForumsTopic $forumsTopic
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereForumsTopicId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereIsUpToDate($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereUpdatedAt($value)
 */
class ForumsWatch extends Model
{
    public static function createWatcher(User $user, ForumsTopic $topic)
    {
        $watch = new static;

        $watch->user_id = $user->id;
        $watch->forums_topic_id = $topic->id;
        $watch->is_up_to_date = true;

        $watch->save();

        return $watch;
    }

    public function forumsTopic()
    {
        return $this->belongsTo(ForumsTopic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}