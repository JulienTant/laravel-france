<?php

namespace LaravelFrance\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsMessage;
use LaravelFrance\ForumsTopic;
use LaravelFrance\ForumsWatch;
use LaravelFrance\Http\Requests\CreateTopicRequest;
use LaravelFrance\Http\Requests\SolveTopicRequest;
use LaravelFrance\Http\Requests\StoreTopicRequest;
use Redirect;
use function foo\func;


class TopicsController extends Controller
{
    public function index(Request $request, $categorySlug = null)
    {
        $chosenCategory = null;
        if ($categorySlug) {
            $chosenCategory = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        }

        $topicsQuery = ForumsTopic::forListing();
        if (!!$chosenCategory) {
            $topicsQuery = $topicsQuery->whereForumsCategoryId($chosenCategory->id);
        }

        if ($request->get('author')) {
            $topicsQuery = $topicsQuery->where('forums_topics.user_id', $request->get('author'));
        }

        if ($request->get('no-answers')) {
            $topicsQuery = $topicsQuery->where('nb_messages', 1);
        }

        if ($from = $request->get('with-msg-from')) {
            $topicsQuery = $topicsQuery->whereHas('forumsMessages', function ($q) use($from) {
                $q->where('forums_messages.user_id', $from);
            });
        }


        $topics =  $topicsQuery->simplePaginate(Config::get('laravelfrance.forums.topics_per_page'));

        return view('topics.index', compact('topics', 'chosenCategory'));
    }

    public function show(Request $request, $categorySlug, $topicSlug)
    {
        $chosenCategory = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($chosenCategory->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();

        $messages = ForumsMessage::with('user')
            ->whereForumsTopicId($topic->id)
            ->orderBy('created_at', 'asc')
            ->paginate(Config::get('laravelfrance.forums.messages_per_page'));


        if ($request->user()) {
            ForumsWatch::markUpToDate($topic, $request->user());
        }

        return view('topics.show', compact('topic', 'chosenCategory', 'messages'));
    }

    public function create(CreateTopicRequest $req)
    {
        $categories = ForumsCategory::orderBy('order')->get();
        return \View::make('topics.create', compact('categories'));
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = ForumsTopic::post(
            $request->user(),
            $request->title,
            $request->category,
            $request->markdown
        );

        return Redirect::route('topics.show', [$topic->forumsCategory->slug, $topic->slug]);
    }

    public function solve(SolveTopicRequest $request, $categorySlug, $topicSlug)
    {
        $messageId = $request->input('message_id');

        $category = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($category->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();
        $topic->solve($messageId);

        return Redirect::route('messages.show', ['messageId' => $messageId]);
    }
}
