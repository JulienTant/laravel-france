<?php

class WikiPageSeeder extends Seeder
{
    public function run()
    {
        Auth::onceUsingId(1);
        \Lvlfr\Wiki\Entities\Page::create(
            array('id' => 1, 'title' => 'Welcome', 'slug' => 'welcome', 'content' => 'je suis la homepage')
        );

        \Lvlfr\Wiki\Entities\Page::create(
            array('id' => 2, 'title' => 'Test', 'slug' => 'test', 'content' => 'je suis la page de test')
        );
    }
}
