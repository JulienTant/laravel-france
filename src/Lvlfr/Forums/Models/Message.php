<?php
namespace Lvlfr\Forums\Models;

use \Decoda;

class Message extends \Eloquent
{
    protected $table = 'forum_messages';

    public function user()
    {
        return $this->belongsTo('\User', 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo('\Lvlfr\Forums\Models\Topic', 'forum_topic_id');
    }

    public static function createNew($categoryId, $topic, $user, $input)
    {
        $message = new Message();
        $message->forum_category_id = $categoryId;
        $message->forum_topic_id = $topic->id;
        $message->user_id = $user->id;
        $message->bbcode = $input['topic_content'];
        $code = new Decoda\Decoda($message->bbcode);
        $code->defaults();
        $message->html = $code->parse();
        $message->save();

        return $message;
    }
}
