<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TheCode200Test extends TestCase
{
    use DatabaseMigrations;

    public function testHomepageisOk()
    {
        $this->visit('/')->see('Laravel France')->seeStatusCode(200);
    }

    public function testForumCategory()
    {
        DB::table('forums_categories')->delete();
        DB::table('forums_categories')->insert([
            'id' => '1',
            'slug' => 'my-slug',
            'name' => 'Name',
            'description' => 'this is for the tests',
            'background_color' => 'red',
            'font_color' => 'white',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->visit('/c/my-slug')->see('this is for the tests')->seeStatusCode(200);
    }

    public function testSlackPageisOk()
    {
        $this->visit('/slack')->see('Laravel France')->seeStatusCode(200);
    }

    public function testContactPageisOk()
    {
        $this->visit('/contact')->see('Laravel France')->seeStatusCode(200);
    }
}
