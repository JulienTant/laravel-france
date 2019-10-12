<?php

namespace LaravelFranceOld\Listeners;

use Craftyx\SlackApi\Contracts\SlackChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaravelFranceOld\Events\ForumsTopicPosted;

class SlackForumsWatcher implements ShouldQueue
{
    use  InteractsWithQueue;

    /**
     * @var SlackChat
     */
    private $slackChat;

    /**
     * Create the event listener.
     *
     * @param SlackChat $slackChat
     */
    public function __construct(SlackChat $slackChat)
    {
        $this->slackChat = $slackChat;
    }

    /**
     * Handle the event.
     *
     * @param  ForumsTopicPosted  $event
     * @return void
     */
    public function whenForumsTopicPosted(ForumsTopicPosted $event)
    {
        $text = sprintf(
            "[Nouveau sujet] %s a créé un nouveau sujet : %s \n %s",
            $event->getUser()->username,
            $event->getTopic()->title,
            route('forums.show-topic', [
                $event->getTopic()->forumsCategory->slug,
                $event->getTopic()->slug,
            ])
        );

        $this->slackChat->postMessage(
            '#forums',
            $text,
            [
                "username" => "Forums Bot",
            ]
        );

        $this->delete();
    }
}
