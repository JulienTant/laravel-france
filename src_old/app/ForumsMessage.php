<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld;


use Illuminate\Database\Eloquent\Model;

/**
 * LaravelFranceOld\ForumsMessage
 *
 * @property integer $id
 * @property integer $forums_topic_id
 * @property integer $user_id
 * @property string $markdown
 * @property boolean $solve_topic
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \LaravelFranceOld\ForumsTopic $forumsTopic
 * @property-read \LaravelFranceOld\User $user
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereForumsTopicId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereMarkdown($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereSolveTopic($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsMessage whereUpdatedAt($value)
 * @mixin \Eloquent
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

    public function setAsTheHeroOfTheDay()
    {
        $this->solve_topic = true;
    }
}
