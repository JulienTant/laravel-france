<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeForeignKeysOnForumTopicsForForumsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums_topics', function (Blueprint $table) {
            $table->foreign('solved_by')
                ->references('id')->on('forums_messages')
                ->onDelete('SET NULL');

            $table->foreign('last_message_id')
                ->references('id')->on('forums_messages')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forums_topics', function (Blueprint $table) {
            $table->dropForeign('forums_topics_solved_by_foreign');
            $table->dropForeign('forums_topics_last_message_id_foreign');
        });
    }
}
