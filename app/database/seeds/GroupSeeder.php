<?php

class GroupSeeder extends Seeder
{
    public function run()
    {
        foreach (
            [
                ['id' => 1, 'name' => 'SuperAdmin'],
                ['id' => 2, 'name' => 'Forums'],
                ['id' => 3, 'name' => 'Wiki'],
                ['id' => 4, 'name' => 'Doc'],
            ]
            as $group) {
            \Lvlfr\Login\Model\Group::create($group);
        }
    }
}
