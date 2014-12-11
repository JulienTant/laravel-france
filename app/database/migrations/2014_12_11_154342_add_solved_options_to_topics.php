<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolvedOptionsToTopics extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'forum_topics',
            function (Blueprint $table) {
                $table->boolean('solved')->default(false);
                $table->integer('solvedBy', false, true)->nullable();
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
            'forum_topics',
            function (Blueprint $table) {
                $table->dropColumn('solved');
                $table->dropColumn('solvedBy');
            }
        );
    }

}
