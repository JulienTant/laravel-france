<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecountNbMessagesByTopic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(\LaravelFrance\ForumsTopic::withCount('forumsMessages')->get() as $topics) {
            $topics->nb_messages = $topics->forums_messages_count;
            $topics->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
