<?php
namespace Lvlfr\Forums\Models;

use \Auth;
use Lvlfr\Login\Model\User;
use \Str;

class Topic extends \Eloquent
{
    protected $table = 'forum_topics';

    public function getDates()
    {
        return ['created_at', 'updated_at', 'lm_date'];
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

        $topic->indexInSearchEngine();

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
                View::create([
                    'topic_id' => $this->id,
                    'category_id' => $this->category->id,
                    'user_id' => \Auth::user()->id
                ]);
            }
        }
    }

    public function isWrittenBy(User $user = null)
    {
        return $user != null && $this->user_id == $user->id;
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

    public function toElasticsearchArray($update = false)
    {
        $params = [];
         $doc = [
            'title' => $this->title,
            'message' => html_entity_decode(strip_tags($this->messages->first()->html), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'message_id' => $this->messages->first()->id,
            'topic_id' => $this->id,
            'category_id' => $this->forum_category_id,
            'author_id' => $this->user->id,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
        if ($update) {
            $params['body']['doc'] = $doc;
        } else {
            $params['body'] = $doc;
        }
        $params['index'] = 'forums';
        $params['type'] = 'messages';
        $params['id'] = $this->id;

        return $params;
    }

    public function indexInSearchEngine($updating = false)
    {
        $message = $this->messages->first();
        if (!is_null($message)) {
            if ($updating) {
                \Elasticsearch::update($this->toElasticsearchArray(true));
            } else {
                \Elasticsearch::index($this->toElasticsearchArray());
            }
        }
    }
}
