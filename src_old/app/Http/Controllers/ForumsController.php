<?php

namespace LaravelFranceOld\Http\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use LaravelFranceOld\ForumsCategory;
use LaravelFranceOld\ForumsMessage;
use LaravelFranceOld\ForumsTopic;
use LaravelFranceOld\ForumsWatch;

class ForumsController extends Controller
{
    /**
     * @var Repository
     */
    private $config;

    function __construct(Repository $config)
    {
        $this->config = $config;
    }


    public function topics($categorySlug = null)
    {
        $chosenCategory = null;
        if ($categorySlug) {
            $chosenCategory = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        }

        $topicsQuery = ForumsTopic::forListing();
        if (!!$chosenCategory) {
            $topicsQuery = $topicsQuery->whereForumsCategoryId($chosenCategory->id);
        }
       $topics =  $topicsQuery->simplePaginate($this->config->get('LaravelFranceOld.forums.topics_per_page'));

        return view('forums.topics', compact('topics', 'chosenCategory'));
    }

    public function topic(Request $request, $categorySlug, $topicSlug)
    {
        $chosenCategory = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($chosenCategory->id)
            ->whereSlug($topicSlug)
            ->orderBy('updated_at', 'DESC')
            ->firstOrFail();

        $messages = \LaravelFranceOld\ForumsMessage::with('user')
            ->whereForumsTopicId($topic->id)
            ->orderBy('created_at', 'asc')
            ->paginate($this->config->get('LaravelFranceOld.forums.messages_per_page'));


        if ($request->user()) {
            ForumsWatch::markUpToDate($topic, $request->user());
        }

        return view('forums.topic', compact('topic', 'chosenCategory', 'messages'));
    }

    public function message($messageId)
    {
        /** @var ForumsMessage $message */
        $message = ForumsMessage::findOrFail($messageId);

        $messagesId = $message->forumsTopic->forumsMessages()
            ->orderBy('created_at',  'asc')
            ->select(['id'])->get(['id'])
            ->pluck('id');

        $index = array_search($message->id, $messagesId->toArray());

        $page = ceil(($index+1) / $this->config->get('laravelfrance.forums.messages_per_page'));

        return redirect(route('forums.show-topic', [$message->forumsTopic->forumsCategory->slug, $message->forumsTopic->slug]) . '?page=' . $page . '#message-' . $messageId);
    }
}
