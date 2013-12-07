<?php
namespace Lvlfr\Forums\Models;

use \Auth;
use \Str;

class Topic extends \Eloquent
{
    protected $table = 'forum_topics';

    public function getDates()
    {
        return array('created_at', 'updated_at', 'lm_date');
    }

    public function category()
    {
        return $this->belongsTo('Lvlfr\Forums\Models\Category', 'forum_category_id');
    }

    public function messages()
    {
        return $this->hasMany('Lvlfr\Forums\Models\Message', 'forum_topic_id');
    }

    public function user()
    {
        return $this->belongsTo('Lvlfr\Login\Model\User', 'user_id');
    }

    public static function createNew($category, $input, $user)
    {
        $topic = new Topic();
        $topic->forum_category_id = $category->id;
        $topic->user_id = $user->id;
        $topic->title = $input['topic_title'];
        $topic->slug = Str::slug($topic->title);
        $topic->save();

        $message = Message::createNew($category, $topic, $user, $input);

        $topic->setLastMessage($message, true);
        $category->setLastMessage($message, true);

        return $topic;
    }

    public static function addReply($topicId, $input, $user)
    {
        $topic = Topic::find($topicId);

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

    public function view($andMarkAsRead = false)
    {
        $this->nb_views++;
        $this->save();

        if (\Auth::guest()) {
            return;
        }

        if ($andMarkAsRead) {
            $fv = View::where('topic_id', '=', $this->id)->where('user_id', '=', \Auth::user()->id)->first();
            if (!is_null($fv)) {
                $fv->touch();
            } else {
                View::create(array(
                    'topic_id' => $this->id,
                    'category_id' => $this->category->id,
                    'user_id' => \Auth::user()->id
                ));
            }
        }
    }

    public function isUnread()
    {
        if (\Auth::guest()) {
            return false;
        }

        $daysUntilRead = \Config::get('LvlfrForums::forums.day_mark_until_mark_as_read');
        $markAsReadAfter = new \DateTime($daysUntilRead .'days ago');
        if ($this->lm_date < $markAsReadAfter) {
            return false;
        }

        if (app()->bound('forums.allUnreadTopics') === false) {
            $topics = View::where('updated_at', '>=', $markAsReadAfter->format('Y-m-d H:i:s'))
                ->where('user_id', '=', \Auth::user()->id)
                ->where('category_id', '=', $this->category->id)
                ->lists('topic_id');

            app()->instance('forums.allUnreadTopics', $topics);
        }
        $topics = app()->make('forums.allUnreadTopics');
        if (array_search($this->id, $topics) !== false) {
            return false;
        }
        return true;
    }
}
