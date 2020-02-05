<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsMessage;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $sQuery = ForumsMessage::search($request->get('q'));

        $chosenCategory = null;
        if ($categoryId = $request->get('forum_category_id')) {
            $sQuery = $sQuery->where('category_id', $categoryId);
            $chosenCategory = ForumsCategory::whereId($categoryId)->firstOrFail();
        }

        $messages = $sQuery->paginate(20);
        $messages->load('forumsTopic');

        return view('topics.search', ['messages' => $messages, 'chosenCategory' => $chosenCategory]);
    }
}
