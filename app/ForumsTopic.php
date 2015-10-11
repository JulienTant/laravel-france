<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Fadion\Bouncy\BouncyTrait;
use Illuminate\Database\Eloquent\Model;

class ForumsTopic extends Model
{
    use BouncyTrait;

    public function forumsMessages()
    {
        return $this->hasMany(ForumsMessage::class);
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
            'content' => $firstMessage ? $firstMessage->html : '',
            'forums_category_id' => $this->forums_category_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }

}