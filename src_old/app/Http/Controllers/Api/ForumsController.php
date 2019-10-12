<?php

namespace LaravelFranceOld\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelFranceOld\ForumsMessage;
use LaravelFranceOld\ForumsTopic;
use LaravelFranceOld\ForumsWatch;
use LaravelFranceOld\Http\Controllers\Controller;
use LaravelFranceOld\Http\Requests\AnswerToTopicRequest;
use LaravelFranceOld\Http\Requests\DeleteMessageRequest;
use LaravelFranceOld\Http\Requests\EditMessageRequest;
use LaravelFranceOld\Http\Requests\SolveTopicRequest;
use LaravelFranceOld\Http\Requests\StoreTopicRequest;

/**
 * Class ForumsController
 * @package LaravelFranceOld\Http\Controllers\Api
 */
class ForumsController extends Controller
{
    /**
     * Store a newly created topic
     *
     * @return StoreTopicRequest
     * @return \Illuminate\Http\Response
     */
    public function post(StoreTopicRequest $request)
    {
        if (str_slug($request->title) == "") {
            return new JsonResponse(["title" => ["Le contenu de votre titre est incorrect."]], 422);
        }


        $topic = ForumsTopic::post(
            $request->user(),
            $request->title,
            $request->category,
            $request->markdown
        );

        return $topic->load('forumsCategory');
    }

    /**
     * Store a reply.
     *
     * @param AnswerToTopicRequest $request
     * @param $topicId
     * @return \Illuminate\Http\Response
     */
    public function reply(AnswerToTopicRequest $request, $topicId)
    {
        /** @var ForumsTopic $topic */
        $topic = ForumsTopic::findOrFail($topicId);

        return $topic->addMessage($request->user(), $request->markdown);
    }


    /**
     * Get a Message From its ID
     *
     * @param $messageId
     * @return mixed
     */
    public function message($topicId, $messageId)
    {
        $topic = ForumsTopic::findOrFail($topicId);

        return $topic->forumsMessages()->findOrFail($messageId);
    }


    /**
     * @param EditMessageRequest $request
     * @param $topicId
     * @param $messageId
     *
     * @return ForumsMessage
     */
    public function updateMessage(EditMessageRequest $request, $topicId, $messageId)
    {
        /** @var ForumsTopic $topic */
        $topic = ForumsTopic::findOrFail($topicId);
        $topic->editMessage($messageId, $request->markdown);

        return $topic->load('forumsCategory');
    }


    /**
     * Remove the specified message from the topic.
     *
     * @param DeleteMessageRequest $request
     * @param $topicId
     * @param $messageId
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMessage(DeleteMessageRequest $request, $topicId, $messageId)
    {
        /** @var ForumsTopic $topic */
        $topic = ForumsTopic::findOrFail($topicId);
        $topic->deleteMessage($messageId);

        return $topic->exists ? $topic->load('forumsCategory') : null;

    }

    public function solveTopic(SolveTopicRequest $request, $topicId, $messageId)
    {
        /** @var ForumsTopic $topic */
        $topic = ForumsTopic::findOrFail($topicId);
        $topic->solve($messageId);

        return $topic->load('forumsCategory');
    }

    public function watch(Request $request, $topicId)
    {
        $watched = ForumsWatch::active()->whereUserId($request->user()->id)->whereForumsTopicId($topicId)->exists();

        return ['watched' => $watched];
    }

    public function toggleWatch(Request $request, $topicId)
    {
        /** @var ForumsTopic $topic */
        $topic = ForumsTopic::findOrFail($topicId);

        /** @var ForumsWatch $forumWatcher */
        $forumWatcher = ForumsWatch::whereUserId($request->user()->id)->whereForumsTopicId($topicId)->first();
        if (!$forumWatcher) {
            ForumsWatch::createWatcher($request->user(), $topic);
        } else {
            $forumWatcher->toggleWatch();
        }


        $watched = ForumsWatch::active()->whereUserId($request->user()->id)->whereForumsTopicId($topicId)->exists();

        return ['watched' => $watched];
    }
}
