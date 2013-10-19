<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableForumTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function ($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('forum_category_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->boolean('sticky')->default(0);
            $table->string('title');
            $table->string('slug');

            $table->integer('nb_messages')->unsigned()->default(1);
            $table->integer('nb_views')->unsigned()->default(0);

            $table->string('lm_user_name', 20)->nullable();
            $table->integer('lm_user_id')->unsigned()->nullable();
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
        Schema::drop('forum_topics');
    }
}
