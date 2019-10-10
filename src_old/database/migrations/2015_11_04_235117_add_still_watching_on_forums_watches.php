<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStillWatchingOnForumsWatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums_watches', function (Blueprint $table) {
            $table->boolean('still_watching')->default(true);
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
            $table->dropColumn('still_watching');
        });
    }
}
