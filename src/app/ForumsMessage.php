<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ForumsMessage extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['topic_title'] = $this->forumsTopic->title;
        $array['category_id'] = $this->forumsTopic->forums_category_id;

        return $array;
    }

    /**
     * Splits the given value.
     *
     * @param  string $value
     * @return array
     */
    public function splitMarkdown($value)
    {
        return str_split(preg_replace('/\s+/', ' ', $value), 9000);
    }

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
