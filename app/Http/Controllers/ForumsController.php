<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;

class ForumsController extends Controller
{
    public function topics($categorySlug = null)
    {
        $chosenCategory = null;
        if ($categorySlug) {
            $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        }

        $topicsQuery = \LaravelFrance\ForumsTopic::join('forums_messages', 'last_message_id', '=', 'forums_messages.id')
            ->select('forums_topics.*')
            ->with('user', 'forumsCategory', 'lastMessage', 'lastMessage.user')
            ->orderBy('forums_messages.created_at', 'DESC')
            ->orderBy('id', 'DESC');
        if ($chosenCategory instanceof ForumsCategory) {
            $topicsQuery = $topicsQuery->where('forums_category_id', $chosenCategory->id);
        }
       $topics =  $topicsQuery->simplePaginate(20);

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
                            'fields' => ["title", "content"]
                        ],
                    ],
                ],
            ],
            'sort' => [
                '_score' => [
                    'order' => 'desc'
                ],
                'created_at' => [
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

        $topics = ForumsTopic::with('user', 'forumsCategory', 'lastMessage', 'lastMessage.user')->findMany($ids);

        $sortedTopics = collect();
        foreach($ids as $id) {
            $sortedTopics->push($topics->find($id));
        }

        return view('forums.search', compact('topics'));

    }

    public function topic($categorySlug, $topicSlug)
    {
        $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = \LaravelFrance\ForumsTopic::where('forums_category_id', $chosenCategory->id)
            ->whereSlug($topicSlug)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $messages = \LaravelFrance\ForumsMessage::with('user')
            ->where('forums_topic_id', $topic->id)
            ->orderBy('created_at', 'asc')
            ->simplePaginate(20);

        return view('forums.topic', compact('topic', 'chosenCategory', 'messages'));
    }
}
