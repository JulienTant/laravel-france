<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Cviebrock\EloquentSluggable\Sluggable;
use Fadion\Bouncy\BouncyTrait;
use Illuminate\Database\Eloquent\Model;
use LaravelFrance\Events\ForumsMessagePostedOnForumsTopic;
use LaravelFrance\Events\ForumsMessageWasDeleted;
use LaravelFrance\Events\ForumsMessageWasEdited;
use LaravelFrance\Events\ForumsTopicPosted;
use LaravelFrance\Events\ForumsTopicWasDeleted;
use LaravelFrance\Events\ForumsTopicWasSolved;

/**
 * LaravelFrance\ForumsTopic
 *
 * @property integer $id
 * @property integer $forums_category_id
 * @property integer $user_id
 * @property boolean $sticky
 * @property string $title
 * @property string $slug
 * @property boolean $solved
 * @property integer $solved_by
 * @property integer $last_message_id
 * @property integer $nb_messages
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ForumsMessage[] $forumsMessages
 * @property-read ForumsMessage $firstMessage
 * @property-read ForumsCategory $forumsCategory
 * @property-read User $user
 * @property-read ForumsMessage $lastMessage
 * @property-read ForumsMessage $solvedBy
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereForumsCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereSticky($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereSolved($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereSolvedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereLastMessageId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereNbMessages($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsTopic forListing()
 */
class ForumsTopic extends Model
{
    use BouncyTrait, Sluggable;

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

        \Event::fire(new ForumsTopicPosted($author, $topic));

        $topic->addMessage($author, $markdown);

        return $topic;
    }

    public function addMessage(User $author, $markdown)
    {
        $message = ForumsMessage::post($author, $markdown);
        $this->forumsMessages()->save($message);

        \Event::fire(new ForumsMessagePostedOnForumsTopic($author, $this, $message));

        return $message;
    }

    public function editMessage($messageId, $markdown)
    {
        /** @var ForumsMessage $message */
        $message = $this->forumsMessages->find($messageId);
        $message->editMarkdown($markdown);
        $message->save();

        \Event::fire(new ForumsMessageWasEdited($message));

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

        \Event::fire(new ForumsTopicWasSolved($this, $message));

        return $this;
    }

    public function incrementNbMessages($step = 1)
    {
        $this->nb_messages += 1;
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
        \Event::fire(new ForumsMessageWasDeleted($message, $updateTopic = !$force));

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
        \Event::fire(new ForumsTopicWasDeleted($this));

        return $this;
    }

    /* ELATISCSEARCH */

    protected $mappingProperties = [
        'id' => ['type' => 'integer', 'include_in_all' => false],
        'title' => ['type' => 'string', 'analyzer' => 'french', 'include_in_all' => true],
        'content' => ['type' => 'string', 'analyzer' => 'french', 'include_in_all' => true],
        'forums_category_id' => ['type' => 'integer', 'include_in_all' => false],
        'created_at' => ['type' => 'date', "format" => "yyyy-MM-dd HH:mm:ss", 'include_in_all' => false],
    ];
    protected $typeName = 'forums_topics';

    public function documentFields()
    {
        $firstMessage = $this->forumsMessages()->orderBy('created_at', 'asc')->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $firstMessage ? $firstMessage->markdown : '',
            'forums_category_id' => $this->forums_category_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }

}
