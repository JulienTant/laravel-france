<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('GroupSeeder');
        $this->call('UserSeeder');

        $this->call('ForumSeeder');

        $this->call('WikiPageSeeder');
        $this->call('WikiVersionSeeder');
    }
}
