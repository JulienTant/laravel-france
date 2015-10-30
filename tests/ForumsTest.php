<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForumsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function categoriesAreVisibleInSidebar()
    {
        $categories = factory(\LaravelFrance\ForumsCategory::class)->times(3)->create();

        $page = $this->visit('/');
        foreach ($categories as $category) {
            $page->see($category->name);
        }
    }

    /** @test */
    public function topicsAreVisibleOnHomepage()
    {
        $user = factory(\LaravelFrance\User::class)->create();
        $category = factory(\LaravelFrance\ForumsCategory::class)->create();

        $topics = factory(\LaravelFrance\ForumsTopic::class)->times(3)->create([
            'forums_category_id' => $category->id,
            'user_id' => $user->id
        ])->each(function (\LaravelFrance\ForumsTopic $topic) use ($user) {
            $message = $topic->forumsMessages()->save(factory(\LaravelFrance\ForumsMessage::class)->make(['user_id' => $user->id]));

            $topic->last_message_id = $message->id;
            $topic->nb_messages = 1;
            $topic->save();
        });

        $page = $this->visit('/');
        foreach ($topics as $topic) {
            $page->see($topic->title);
        }


    }

    /** @test */
    public function canVisitTopic()
    {
        $user = factory(\LaravelFrance\User::class)->create();

        $category = factory(\LaravelFrance\ForumsCategory::class)->create();

        $topic = factory(\LaravelFrance\ForumsTopic::class)->create([
            'forums_category_id' => $category->id,
            'user_id' => $user->id
        ]);
        $message = $topic->forumsMessages()->save(factory(\LaravelFrance\ForumsMessage::class)->make(['user_id' => $user->id]));
        $topic->last_message_id = $message->id;
        $topic->nb_messages = 1;
        $topic->save();

        $this->visit(route('forums.show-topic', [$category->slug, $topic->slug]))
            ->see($topic->title)
            ->see($category->title)
            ->see($user->username);
    }


    /** @test */
    public function canEditMyMessage()
    {
        $user = factory(\LaravelFrance\User::class)->create();
        $this->be($user);

        $category = factory(\LaravelFrance\ForumsCategory::class)->create();

        $topic = factory(\LaravelFrance\ForumsTopic::class)->create([
            'forums_category_id' => $category->id,
            'user_id' => $user->id
        ]);
        $message = $topic->forumsMessages()->save(factory(\LaravelFrance\ForumsMessage::class)->make(['user_id' => $user->id]));
        $topic->last_message_id = $message->id;
        $topic->nb_messages = 1;
        $topic->save();

        $this->visit(route('forums.show-topic', [$category->slug, $topic->slug]))->see('Editer');
    }


    /** @test */
    public function cantEditOthersMessage()
    {
        $user = factory(\LaravelFrance\User::class)->create();
        $secondUser = factory(\LaravelFrance\User::class)->create();
        $this->be($secondUser);

        $category = factory(\LaravelFrance\ForumsCategory::class)->create();

        $topic = factory(\LaravelFrance\ForumsTopic::class)->create([
            'forums_category_id' => $category->id,
            'user_id' => $user->id
        ]);
        $message = $topic->forumsMessages()->save(factory(\LaravelFrance\ForumsMessage::class)->make(['user_id' => $user->id]));
        $topic->last_message_id = $message->id;
        $topic->nb_messages = 1;
        $topic->save();

        $this->visit(route('forums.show-topic', [$category->slug, $topic->slug]))->dontSee('Editer');
    }
}

