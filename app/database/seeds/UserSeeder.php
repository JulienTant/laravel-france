<?php

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(
            array('username' => 'AoSiX', 'email' => 'julien@laravel.fr')
        );

        \Lvlfr\Login\Model\OAuth::create(
            array('user_id' =>  1, 'provider' => 'GitHub', 'uid' => '785518')
        );
    }
}
