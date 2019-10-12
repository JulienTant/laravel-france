<?php

namespace LaravelFrance\Http\Controllers;

use Config;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Http\Requests\AnswerToTopicRequest;
use LaravelFrance\ForumsMessage;
use LaravelFrance\Http\Requests\DeleteMessageRequest;
use LaravelFrance\Http\Requests\EditMessageRequest;
use Redirect;
use URL;

class MessagesController extends Controller
{
    public function store(AnswerToTopicRequest $request)
    {
        $message = $request->topic->addMessage($request->user(), $request->markdown);

        return Redirect::route('messages.show', ['messageId' => $message->id]);
    }

    public function show($messageId)
    {
        /** @var ForumsMessage $message */
        $message = ForumsMessage::findOrFail($messageId);

        $messagesId = $message->forumsTopic->forumsMessages()
            ->orderBy('created_at',  'asc')
            ->select(['id'])->get(['id'])
            ->pluck('id');

        $index = array_search($message->id, $messagesId->toArray());

        $page = ceil(($index+1) / Config::get('laravelfrance.forums.messages_per_page'));

        return Redirect::to(URL::route('topics.show', [$message->forumsTopic->forumsCategory->slug, $message->forumsTopic->slug]) . '?page=' . $page . '#message-' . $messageId);

    }

    public function edit(EditMessageRequest $request, $categorySlug, $topicSlug, $messageId)
    {
        $category = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($category->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();
        $message = $topic->forumsMessages()->findOrFail($messageId);

        return \View::make('topics.edit', compact('category', 'topic', 'message'));
    }

    public function update(EditMessageRequest $request, $categorySlug, $topicSlug, $messageId)
    {
        $category = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($category->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();

        $topic->editMessage($messageId, $request->markdown);

        return Redirect::route('messages.show', ['messageId' => $messageId]);
    }

    public function remove(DeleteMessageRequest $request, $categorySlug, $topicSlug, $messageId)
    {
        $category = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($category->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();
        $message = $topic->forumsMessages()->findOrFail($messageId);

        return \View::make('topics.remove', compact('category', 'topic', 'message'));
    }

    public function delete(DeleteMessageRequest $request, $categorySlug, $topicSlug, $messageId)
    {
        $category = ForumsCategory::whereSlug($categorySlug)->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($category->id)
            ->whereSlug($topicSlug)
            ->firstOrFail();
        $topic->deleteMessage($messageId);

        $to = URL::route('topics.show', [$categorySlug, $topicSlug]);
        if (!$topic->exists) {
            $to = URL::route('topics.by-category', [$categorySlug]);
        }
        return Redirect::to($to);
    }
}
