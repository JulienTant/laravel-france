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

    public function isUnread()
    {
        if (\Auth::guest()) {
            return false;
        }

        $daysUntilRead = \Config::get('LvlfrForums::forums.day_mark_until_mark_as_read');
        $markAsReadAfter = new \DateTime($daysUntilRead .'days ago');
        if ($this->updated_at < $markAsReadAfter) {
            return false;
        }


        if (app()->bound('forums.allUnreadTopics') === false) {
            $topics = View::where('updated_at', '>=', $markAsReadAfter->format('Y-m-d H:i:s'))
                ->where('user_id', '=', \Auth::user()->id)
                ->lists('topic_id');

            app()->instance('forums.allUnreadTopics', $topics);
        }

        $tv = app()->make('forums.allUnreadTopics');
        $nb = count($tv);

        $view = Topic::where('forum_category_id', '=', $this->id)->where('updated_at', '>=', $markAsReadAfter->format('Y-m-d H:i:s'));
        if ($nb > 0) {
            $view = $view->whereNotIn('id', $tv);
        }
        $view = $view->count();

        if ($nb == 0 && $view > 0) {
            return true;
        }
        if ($view > 0) {
            return true;
        }
        return false;
    }
}
