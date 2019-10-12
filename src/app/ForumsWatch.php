<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;

class ForumsWatch extends Model
{
    public static function createWatcher(User $user, ForumsTopic $topic)
    {
        $watch = new static;

        $watch->user_id = $user->id;
        $watch->forums_topic_id = $topic->id;
        $watch->upToDate();

        $watch->save();

        return $watch;
    }

    public static function markUpToDate(ForumsTopic $topic, User $user)
    {
        $watcher = self::whereForumsTopicId($topic->id)->whereUserId($user->id)->active()->first();
        if ($watcher) {
            $watcher->upToDate();
            $watcher->save();
        }
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

    public function firstUnreadMessage()
    {
        return $this->belongsTo(ForumsMessage::class);
    }

    public function toggleWatch()
    {
        $this->still_watching = !$this->still_watching;
        $this->upToDate();

        $this->save();
    }

    public function noMoreUpToDate(ForumsMessage $message = null)
    {
        $this->is_up_to_date = false;
        if (!$this->first_unread_message_id) {
            $this->first_unread_message_id = !is_null($message) ? $message->id : null;
        }
    }

    public function upToDate()
    {
        $this->is_up_to_date = true;
        $this->first_unread_message_id = null;
    }

}
