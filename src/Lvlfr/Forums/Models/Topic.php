<?php
namespace Lvlfr\Forums\Models;

use \Auth;
use \Str;
use \Decoda;

class Topic extends \Eloquent
{
    protected $table = 'forum_topics';

    public function category()
    {
        return $this->belongsTo('Lvlfr\Forums\Models\Category', 'forum_category_id');
    }

    public function user()
    {
        return $this->belongsTo('\User', 'user_id');
    }

    public static function createNew($categoryId, $input, $user)
    {
        $topic = new Topic();
        $topic->forum_category_id = $categoryId;
        $topic->user_id = $user->id;
        $topic->title = $input['topic_title'];
        $topic->slug = Str::slug($topic->title);
        $topic->save();

        $message = Message::createNew($categoryId, $topic, $user, $input);

        $topic->setLastMessage($message, true);
        $topic->category->setLastMessage($message, true);

        $user->newForumMessage();

        return $topic;
    }

    public function setLastMessage($message, $newTopic = false)
    {
        if ($newTopic) {
            $this->nb_messages = 1;
        } else {
            $this->nb_messages++;
        }

        $this->lm_user_name = $message->user->username;

        $this->lm_user_id = $message->user->id;
        $this->lm_post_id = $message->id;
        $this->lm_date = $message->created_at;
        $this->save();
    }
}
