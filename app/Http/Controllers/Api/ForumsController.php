<?php

namespace LaravelFrance\Http\Controllers\Api;

use Illuminate\Http\Request;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;
use LaravelFrance\Http\Requests\StoreTopicRequest;

/**
 * Class ForumsController
 * @package LaravelFrance\Http\Controllers\Api
 */
class ForumsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return StoreTopicRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        $topic = ForumsTopic::post(
            $request->user(),
            $request->get('title'),
            $request->get('category'),
            $request->get('markdown')
        );

        return $topic->load('forumsCategory');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
