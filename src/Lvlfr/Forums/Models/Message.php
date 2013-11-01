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

    public static function createNew($category, $topic, $user, $input)
    {
        $text= isset($input['message_content']) ? $input['message_content'] : $input['topic_content'];

        $message = new Message();
        $message->forum_category_id = $category->id;
        $message->forum_topic_id = $topic->id;
        $message->user_id = $user->id;
        $message->bbcode = $text;
        $code = new Decoda\Decoda($message->bbcode);
        $code->defaults();
        $message->html = $code->parse();
        $message->save();

        $user->newForumMessage();

        return $message;
    }

    public function editable()
    {
        if (\Auth::guest()) {
            return false;
        } elseif ($this->user_id == \Auth::user()->id || \Auth::user()->hasRole('Forums')) {
            return true;
        }
        return false;
    }
}
