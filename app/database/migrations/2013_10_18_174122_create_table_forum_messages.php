<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableForumMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_messages', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->text('html');
            $table->text('bbcode');

            $table->integer('user_id')->unsigned();
            $table->integer('forum_topic_id')->unsigned();
            $table->integer('forum_category_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_messages');
    }
}
