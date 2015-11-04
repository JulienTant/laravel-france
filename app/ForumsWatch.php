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
 * @property boolean $still_watching
 * @property-read ForumsTopic $forumsTopic
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereForumsTopicId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereIsUpToDate($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch whereStillWatching($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch mailable()
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsWatch active()
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

    public function scopeMailable($query)
    {
        return $query->active()->where('is_up_to_date', true);
    }

    public function scopeActive($query)
    {
        return $query->where('still_watching', true);
    }

    public function forumsTopic()
    {
        return $this->belongsTo(ForumsTopic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toggleWatch()
    {
        $this->still_watching = !$this->still_watching;
        $this->save();
    }

}