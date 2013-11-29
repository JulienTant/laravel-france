<?php

class ForumSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getCategories() as $cat) {
            \Lvlfr\Forums\Models\Category::create($cat);
        }

        foreach ($this->getTopics() as $topic) {
            \Lvlfr\Forums\Models\Topic::create($topic);
        }

        foreach ($this->getMEssages() as $message) {
            \Lvlfr\Forums\Models\Message::create($message);
        }
    }

    private function getCategories()
    {
        return array(
            array(
                'order' => 1,
                'title' => 'Forum n°1',
                'slug' => 'forum-n-1',
                'desc' => 'Description du forum n°1',
                'nb_topics' => 0,
                'nb_posts' => 0,
            ),
            array(
                'order' => 2,
                'title' => 'Forum n°2',
                'slug' => 'forum-n-2',
                'desc' => 'Description du forum n°2',
                'nb_topics' => 0,
                'nb_posts' => 0,
            )
        );
    }

    private function getTopics()
    {
        return array(
            array(
                'forum_category_id' => '1',
                'user_id' => '1',
                'sticky' => '0',
                'title' => 'Topic 1',
                'slug' => 'topic-1',
                'lm_date' => new DateTime(),
            ),
            array(
                'forum_category_id' => '2',
                'user_id' => '1',
                'sticky' => '0',
                'title' => 'Topic 2',
                'slug' => 'topic-2',
                'lm_date' => new DateTime(),
            ),
            array(
                'forum_category_id' => '1',
                'user_id' => '1',
                'sticky' => '1',
                'title' => 'Topic 3',
                'slug' => 'topic-3',
                'lm_date' => new DateTime(),
            ),
        );
    }

    private function getMessages()
    {
        return array(
            array(
                'html' => 'Hello <strong>1</strong>',
                'bbcode' => 'Hello [b]1[/b]',
                'user_id' => '1',
                'forum_topic_id' => '1',
                'forum_category_id' => '1',
            ),
            array(
                'html' => 'Hello <strong>2</strong>',
                'bbcode' => 'Hello [b]2[/b]',
                'user_id' => '1',
                'forum_topic_id' => '2',
                'forum_category_id' => '1',
            ),
            array(
                'html' => 'Hello <strong>3</strong>',
                'bbcode' => 'Hello [b]3[/b]',
                'user_id' => '1',
                'forum_topic_id' => '3',
                'forum_category_id' => '1',
            ),
            array(
                'html' => 'Hello <strong>4</strong>',
                'bbcode' => 'Hello [b]4[/b]',
                'user_id' => '1',
                'forum_topic_id' => '3',
                'forum_category_id' => '1',
            ),
        );
    }
}