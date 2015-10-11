<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'forums.index', function () {
    $topics = \LaravelFrance\ForumsTopic::join('forums_messages', 'last_message_id', '=', 'forums_messages.id')
        ->select('forums_topics.*')
        ->with('user', 'forumsCategory')
        ->orderBy('forums_messages.created_at', 'DESC')
        ->simplePaginate(20);
    return view('forums.topics', compact('topics'));
}]);

Route::get('/c/{slug}', ['as' => 'forums.by-category', function ($slug) {
    $chosenCategory = \LaravelFrance\ForumsCategory::whereSlug($slug)->firstOrFail();

    $topics = \LaravelFrance\ForumsTopic::join('forums_messages', 'last_message_id', '=', 'forums_messages.id')
        ->select('forums_topics.*')
        ->with('user', 'forumsCategory')
        ->where('forums_category_id', $chosenCategory->id)
        ->orderBy('updated_at', 'DESC')
        ->simplePaginate(20);

    return view('forums.topics', compact('topics', 'chosenCategory'));
}]);

Route::get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', function ($categorySlug, $topicSlug) {

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
}]);