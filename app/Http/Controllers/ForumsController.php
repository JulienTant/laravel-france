<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsMessage;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Http\Requests;

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
            $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        }

        $topicsQuery = \LaravelFrance\ForumsTopic::forListing();
        if (!!$chosenCategory) {
            $topicsQuery = $topicsQuery->whereForumsCategoryId($chosenCategory->id);
        }
       $topics =  $topicsQuery->simplePaginate($this->config->get('laravelfrance.forums.topics_per_page'));

        return view('forums.topics', compact('topics', 'chosenCategory'));
    }

    public function search(Request $request)
    {
        $searchArray = [
            "size" => 100,
            "query" => [
                "filtered" => [
                    'query' => [
                        'multi_match' => [
                            'query' => $request->get('q'),
                            'fields' => ["title^2", "content"]
                        ],
                    ],
                ],
            ],
            'sort' => [
                '_score' => [
                    'order' => 'desc'
                ]
            ]
        ];

        if ($request->get('c') && $category = ForumsCategory::whereSlug($request->get('c'))->first()) {
            $searchArray['query']['filtered']['filter'] = [
                'term' => ['forums_category_id' => $category->id]
            ];
        }

        $ids = ForumsTopic::search($searchArray)->toBase()->lists('id');

        $topics = ForumsTopic::with('user', 'forumsCategory', 'lastMessage', 'lastMessage.user',  'firstMessage')->findMany($ids);

        $sortedTopics = collect();
        foreach($ids as $id) {
            $sortedTopics->push($topics->find($id));
        }


        return view('forums.search', ['topics' => $sortedTopics]);

    }

    public function topic($categorySlug, $topicSlug)
    {
        $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = \LaravelFrance\ForumsTopic::whereForumsCategoryId($chosenCategory->id)
            ->whereSlug($topicSlug)
            ->orderBy('updated_at', 'DESC')
            ->firstOrFail();

        $messages = \LaravelFrance\ForumsMessage::with('user')
            ->whereForumsTopicId($topic->id)
            ->orderBy('created_at', 'asc')
            ->paginate($this->config->get('laravelfrance.forums.messages_per_page'));

        return view('forums.topic', compact('topic', 'chosenCategory', 'messages'));
    }

    public function message($messageId)
    {
        /** @var ForumsMessage $message */
        $message = ForumsMessage::findOrFail($messageId);

        $messagesId = $message->forumsTopic->forumsMessages()
            ->orderBy('created_at',  'asc')
            ->select(['id'])->get(['id'])
            ->lists('id');

        $index = array_search($message->id, $messagesId->toArray());

        $page = ceil(($index+1) / $this->config->get('laravelfrance.forums.messages_per_page'));

        return redirect(route('forums.show-topic', [$message->forumsTopic->forumsCategory->slug, $message->forumsTopic->slug]) . '?page=' . $page . '#message-' . $messageId);
    }
}
