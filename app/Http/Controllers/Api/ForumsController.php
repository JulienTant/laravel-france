<?php

namespace LaravelFrance\Http\Controllers\Api;

use Illuminate\Http\Request;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;
use LaravelFrance\Http\Requests\AnswerToTopicRequest;
use LaravelFrance\Http\Requests\StoreTopicRequest;

/**
 * Class ForumsController
 * @package LaravelFrance\Http\Controllers\Api
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
