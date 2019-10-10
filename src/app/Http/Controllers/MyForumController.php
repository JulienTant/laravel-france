<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use LaravelFrance\User;

class MyForumController extends Controller
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Guard $guard, Repository $config)
    {
        $this->user = $guard->user();
        $this->config = $config;
    }


    public function watchedTopics(Request $request)
    {
        $baseQuery = $this->user->watchedTopics()->active()->with('forumsTopic');
        if (!$request->has('all')) {
            $baseQuery->where('is_up_to_date', false);
        }
        /** @var Collection $watchedTopics */
        $watchedTopics = $baseQuery->get()->sortByDesc(function($watchedTopic) {
            return $watchedTopic->forumsTopic->created_at;
        });

        $hasMore = null;
        if ($watchedTopics->count() == 0 && !$request->has('all')) {
            $hasMore = $this->user->watchedTopics()->active()->count();
        }


        return view('my-forums.watched_topics', compact('watchedTopics', 'chosenCategory', 'hasMore'));
    }

    public function myTopics()
    {
        $topics = \LaravelFrance\ForumsTopic::forListing()->whereRaw('forums_topics.user_id = ?', [$this->user->id])->paginate($this->config->get('laravelfrance.forums.topics_per_page'));
        $chosenCategory = null;
        return view('forums.topics', compact('topics', 'chosenCategory'));

    }

    public function myMessages()
    {
        $messages = \LaravelFrance\ForumsMessage::whereUserId($this->user->id)
            ->with('forumsTopic', 'forumsTopic.forumsCategory')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->config->get('laravelfrance.forums.messages_per_page'));

        return view('my-forums.messages', compact('messages', 'chosenCategory'));

    }
}