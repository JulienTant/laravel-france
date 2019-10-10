<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNbMessagesInForumsTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums_topics', function (Blueprint $table) {
            $table->integer('nb_messages', false, true)->default(0)->after('last_message_id');
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
            $table->dropColumn('nb_messages');
        });
    }
}
