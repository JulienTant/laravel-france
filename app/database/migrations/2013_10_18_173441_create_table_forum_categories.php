<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableForumCategories extends Migration
{
    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_categories', function ($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('order')->unsigned()->default(9999);

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('desc')->nullable();

            $table->integer('nb_topics')->unsigned()->default(0);
            $table->integer('nb_posts')->unsigned()->default(0);

            $table->string('lm_user_name', 20)->nullable();
            $table->integer('lm_user_id')->unsigned()->nullable();
            $table->string('lm_topic_name')->nullable();
            $table->string('lm_topic_slug')->nullable();
            $table->integer('lm_topic_id')->unsigned()->nullable();
            $table->integer('lm_post_id')->unsigned()->nullable();
            $table->datetime('lm_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_categories');
    }
}
