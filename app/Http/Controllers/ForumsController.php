<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFrance\ForumsCategory;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;

class ForumsController extends Controller
{
    public function topics($slug = null)
    {
        $chosenCategory = null;
        if ($slug) {
            $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($slug)->firstOrFail();
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
