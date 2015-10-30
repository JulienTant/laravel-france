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

    public function testSlackPageisOk()
    {
        $this->visit('/slack')->see('Laravel France')->seeStatusCode(200);
    }

    public function testContactPageisOk()
    {
        $this->visit('/contact')->see('Laravel France')->seeStatusCode(200);
    }
}
