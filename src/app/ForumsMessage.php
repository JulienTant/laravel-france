<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;

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
