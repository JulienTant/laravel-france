<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\Events\ForumsMessageWasEdited;
use LaravelFrance\Events\ForumsTopicPosted;
use LaravelFrance\Events\ForumsTopicWasDeleted;
use LaravelFrance\Events\ForumsTopicWasSolved;

class ForumsTopic extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function forumsMessages()
    {
        return $this->hasMany(ForumsMessage::class);
    }

    public function scopeForListing($query)
    {
        return $query->join('forums_messages', 'last_message_id', '=', 'forums_messages.id')
            ->select('forums_topics.*')
            ->with('user', 'forumsCategory', 'lastMessage', 'lastMessage.user',  'firstMessage')
            ->orderBy('forums_messages.created_at', 'DESC')
            ->orderBy('id', 'DESC');
    }

    public function firstMessage()
    {
        return $this->hasOne(ForumsMessage::class)->orderBy('created_at', 'ASC');
    }

    public function forumsCategory()
    {
        return $this->belongsTo(ForumsCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastMessage()
    {
        return $this->belongsTo(ForumsMessage::class, 'last_message_id');
    }

    public function solvedBy()
    {
        return $this->belongsTo(ForumsMessage::class, 'solved_by');
    }

    public static function post(User $author, $title, $category, $markdown)
    {
        $topic = new static;

        $topic->user_id = $author->getKey();
        $topic->forums_category_id = $category;
        $topic->title = $title;
        $topic->save();

        \Event::dispatch(new ForumsTopicPosted($author, $topic));

        $topic->addMessage($author, $markdown);

        return $topic;
    }

    public function addMessage(User $author, $markdown)
    {
        $message = ForumsMessage::post($author, $markdown);
        $this->forumsMessages()->save($message);

        \Event::dispatch(new ForumsMessagePostedOnForumsTopic($author, $this, $message));

        return $message;
    }

    public function editMessage($messageId, $markdown)
    {
        /** @var ForumsMessage $message */
        $message = $this->forumsMessages()->findOrFail($messageId);
        $message->editMarkdown($markdown);
        $message->save();

        \Event::dispatch(new ForumsMessageWasEdited($message));

        return $message;
    }


    public function solve($messageId)
    {
        /** @var ForumsMessage $message */
        $message = $this->forumsMessages->find($messageId);
        $message->setAsTheHeroOfTheDay();
        $message->save();

        $this->solved = true;
        $this->solvedBy()->associate($message);
        $this->save();

        \Event::dispatch(new ForumsTopicWasSolved($this, $message));

        return $this;
    }

    public function incrementNbMessages($step = 1)
    {
        $this->nb_messages += $step;
    }

    public function decrementNbMessages()
    {
        $this->incrementNbMessages(-1);
    }

    public function deleteMessage($messageId, $force = false)
    {
        $message = $this->forumsMessages->find($messageId);

        // If the message is the first message of a topic, then
        // we have to remove all messages and then the topic
        if (($message->id == $this->firstMessage->id) && $force == false) {
            return $this->deleteTopic();
        }

        $message->delete();
        \Event::dispatch(new ForumsMessageWasDeleted($message, $updateTopic = !$force));

        return $message;
    }


    /**
     * @return $this
     */
    public function deleteTopic()
    {
        foreach($this->forumsMessages->pluck('id') as $messageId) {
            $this->deleteMessage($messageId, $force = true);
        }
        $this->delete();
        \Event::dispatch(new ForumsTopicWasDeleted($this));

        return $this;
    }
}
