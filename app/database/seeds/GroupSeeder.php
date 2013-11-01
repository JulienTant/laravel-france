<?php

class GroupSeeder extends Seeder
{
    public function run()
    {
        foreach (array(
            array('id' => 1, 'name' => 'SuperAdmin'),
            array('id' => 2, 'name' => 'Forums'),
        ) as $group) {
            Group::create($group);
        }
    }
}
