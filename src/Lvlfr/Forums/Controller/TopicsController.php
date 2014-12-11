<?php

namespace Lvlfr\Forums\Controller;

use \Lvlfr\Forums\Models\Category;
use \Lvlfr\Forums\Models\Topic;
use \Lvlfr\Forums\Models\Message;
use \App;
use \Auth;
use \Config;
use \BBCodeParser;
use \Input;
use \Redirect;
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

        $andMarkAsRead = false;
        if ($messages->getCurrentPage() == $messages->getLastPage()) {
            $andMarkAsRead = true;
        }
        $topic->view($andMarkAsRead);

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

    public function newTopic($slug, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            App::abort('404', 'Catégorie non trouvée');
        }

        return View::make('LvlfrForums::new', array(
            'category' => $category,
        ));
    }

    public function postNew($slug, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            App::abort('404', 'Catégorie non trouvée');
        }

        $validator = new \Lvlfr\Forums\Validation\NewTopicValidator(Input::all());

        if ($validator->passes()) {
            $topic = Topic::createNew($category, Input::all(), Auth::user());

            return Redirect::action('\Lvlfr\Forums\Controller\TopicsController@show', array($topic->slug, $topic->id));
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function newReply($slug, $topicId)
    {
        $topic = Topic::find($topicId);
        if (!$topic) {
            App::abort('404', 'Sujet non trouvé');
        }
        $messages = Message::with('user')->where('forum_topic_id', '=', $topicId)->orderBy('created_at', 'desc')->take(5)->get();

        $cite = null;
        if ($quote = Message::with('user')->where('id', '=', Input::get('quote'))->first()) {
            $cite = '[quote="'.$quote->user->username.'"]'.$quote->bbcode.'[/quote]';
        }

        return View::make('LvlfrForums::reply', array(
            'topic' => $topic,
            'cite' => $cite,
            'messages' => $messages,
        ));
    }

    public function postReply($slug, $topicId)
    {
        $topic = Topic::find($topicId);
        if (!$topic) {
            App::abort('404', 'Sujet non trouvé');
        }

        $validator = new \Lvlfr\Forums\Validation\PostReplyValidator(Input::all());

        if ($validator->passes()) {
            $message = Message::createNew($topic->category, $topic, Auth::user(), Input::all());
            $topic->setLastMessage($message);
            $topic->category->setLastMessage($message);

            return Redirect::action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($topic->slug, $topic->id));
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function editMessage($slug, $topicId, $messageId)
    {
        $message = Message::find($messageId);
        if (!$message || !$message->editable()) {
            App::abort('404', 'Message non trouvé');
        }

        return View::make('LvlfrForums::edit', array(
            'topic' => $message->topic,
            'message' => $message,
        ));
    }

    public function postEditMessage($slug, $topicId, $messageId)
    {
        $message = Message::find($messageId);
        if (!$message || !$message->editable()) {
            App::abort('404', 'Message non trouvé');
        }


        $validator = new \Lvlfr\Forums\Validation\EditReplyValidator(Input::all());

        if ($validator->passes()) {
            if (Input::has('title')) {
                $message->topic->title = Input::get('title');
                $message->topic->save();
            }
            $message->bbcode = Input::get('message_content');
            $message->html = BBCodeParser::parse($message->bbcode);

            $message->save();

            return Redirect::action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($message->topic->slug, $message->topic->id));
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function solve()
    {
        $topic = Topic::find(Input::get('topic'));
        if (!$topic || $topic->solved == true) {
            App::abort('404', 'Sujet non trouvé');
        }

        $message = Message::find(Input::get('message'));
        if (!$message || !$message->editable()) {
            App::abort('404', 'Message non trouvé');
        }

        if ($message->user_id != \Auth::user()->id) {
            App::abort('404', 'Message non trouvé');
        }

        $topic->solved = true;
        $topic->solvedBy = $message->id;

        $message->solveTopic = true;

        $topic->save();
        $message->save();

        return Redirect::back();
    }
}
