<?php

namespace Lvlfr\Forums\Controller;

use \Lvlfr\Forums\Models\Category;
use \Lvlfr\Forums\Models\Topic;
use \Lvlfr\Forums\Models\Message;
use \App;
use \Config;
use \View;

class TopicsController extends \BaseController
{
    public function index($slug, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            App::abort('404', 'Catégorie non trouvée');
        }

        $topics = Topic::where('forum_category_id', '=', $categoryId)->orderBy('sticky', 'desc')->orderBy('lm_date', 'desc')->paginate(Config::get('LvlfrForums::forums.nb_topics_per_page'));

        return View::make('LvlfrForums::topics', array(
            'category' => $category,
            'topics' => $topics,
        ));
    }

    public function show($slug, $topicId)
    {
        $topic = Topic::with(array('user','category'))->find($topicId);
        if (!$topic) {
            App::abort('404', 'Sujet non trouvé');
        }
        $messages = Message::with('user')->where('forum_topic_id', '=', $topicId)->orderBy('created_at', 'asc')->paginate(Config::get('LvlfrForums::forums.nb_messages_per_page'));

        return View::make('LvlfrForums::topic', array(
            'category' => $topic->category,
            'topic' => $topic,
            'messages' => $messages,
        ));
    }

    public function moveToLast($slug, $topicId)
    {
        $page = ceil(Message::where('forum_topic_id', '=', $topicId)->count() / Config::get('LvlfrForums::forums.nb_messages_per_page'));
        return \Redirect::action('\Lvlfr\Forums\Controller\TopicsController@show', array('slug' => $slug, 'topicId' => $topicId, 'page' => $page), '303');
    }
}
