<?php
namespace Lvlfr\Forums\Services;

use Lvlfr\Forums\Models\Topic;
use Lvlfr\Forums\Models\View;

class MarkAllAsRead
{
    public function forUser($user)
    {
        $daysUntilRead = \Config::get('LvlfrForums::forums.day_mark_until_mark_as_read');
        $markAsReadAfter = new \DateTime($daysUntilRead .'days ago');

        $topics = Topic::with('category')->where('lm_date', '>', $markAsReadAfter->format('Y-m-d H:i:s'))->get();
        View::where('user_id', '=', $user->id)->delete();
        foreach($topics as $topic) {
            View::create([
                'topic_id' => $topic->id,
                'category_id' => $topic->category->id,
                'user_id' => $user->id
            ]);
        }

    }
}