<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolveTopicOptionsToMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'forum_messages',
            function (Blueprint $table) {
                $table->boolean('solveTopic')->default(false);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'forum_messages',
            function (Blueprint $table) {
                $table->dropColumn('solveTopic');
            }
        );
    }
}
