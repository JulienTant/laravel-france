<?php

use Illuminate\Database\Migrations\Migration;

class CreateForumsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_categories', function ($table) {
            $table->foreign('lm_user_id')->references('id')->on('users');
            $table->foreign('lm_topic_id')->references('id')->on('forum_topics');
            $table->foreign('lm_post_id')->references('id')->on('forum_messages');
        });

        Schema::table('forum_topics', function ($table) {
            $table->foreign('forum_category_id')->references('id')->on('forum_categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lm_user_id')->references('id')->on('users');
            $table->foreign('lm_post_id')->references('id')->on('forum_messages');
        });

        Schema::table('forum_messages', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('forum_topic_id')->references('id')->on('forum_topics');
            $table->foreign('forum_category_id')->references('id')->on('forum_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_categories', function ($table) {
            $table->dropForeign('forum_categories_lm_user_id_foreign');
            $table->dropForeign('forum_categories_lm_topic_id_foreign');
            $table->dropForeign('forum_categories_lm_post_id_foreign');
        });

        Schema::table('forum_topics', function ($table) {
            $table->dropForeign('forum_topics_user_id_foreign');
            $table->dropForeign('forum_topics_forum_category_id_foreign');
            $table->dropForeign('forum_topics_lm_user_id_foreign');
            $table->dropForeign('forum_topics_lm_post_id_foreign');
        });

        Schema::table('forum_messages', function ($table) {
            $table->dropForeign('forum_messages_user_id_foreign');
            $table->dropForeign('forum_messages_forum_topic_id_foreign');
            $table->dropForeign('forum_messages_forum_category_id_foreign');
        });
    }
}
