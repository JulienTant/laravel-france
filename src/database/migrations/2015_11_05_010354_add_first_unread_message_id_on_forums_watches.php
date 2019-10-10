<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstUnreadMessageIdOnForumsWatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums_watches', function (Blueprint $table) {
            $table->integer('first_unread_message_id', false, true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forums_watches', function (Blueprint $table) {
            $table->dropColumn('first_unread_message_id');
        });
    }
}
