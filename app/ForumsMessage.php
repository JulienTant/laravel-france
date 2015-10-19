<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;

/**
 * LaravelFrance\ForumsMessage
 *
 * @property integer $id
 * @property integer $forums_topic_id
 * @property integer $user_id
 * @property string $markdown
 * @property boolean $solve_topic
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read ForumsTopic $forumsTopic
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereForumsTopicId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereMarkdown($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereSolveTopic($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsMessage whereUpdatedAt($value)
 */
class ForumsMessage extends Model
{
    public function forumsTopic()
    {
        return $this->belongsTo(ForumsTopic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function post(User $author, $markdown)
    {
        $message = new static;
        $message->user_id = $author->getKey();
        $message->markdown = $markdown;

        return $message;
    }

    public function editMarkdown($markdown)
    {
        $this->markdown = $markdown;

        return $this;
    }
}