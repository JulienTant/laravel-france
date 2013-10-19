<?php
namespace Lvlfr\Forums\Models;

class Category extends \Eloquent
{
    protected $table = 'forum_categories';

    public function setLastMessage($message, $newTopic = false)
    {
        if ($newTopic) {
            $this->nb_topics++;
        }
        $this->nb_posts++;

        $this->lm_user_name = $message->user->username;
        $this->lm_user_id = $message->user->id;
        $this->lm_topic_name = $message->topic->title;
        $this->lm_topic_slug = $message->topic->slug;
        $this->lm_topic_id = $message->topic->id;
        $this->lm_post_id = $message->id;
        $this->lm_date = $message->created_at;
        $this->save();
    }
}
