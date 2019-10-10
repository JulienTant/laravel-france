<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveHtmlFromForumsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums_messages', function (Blueprint $table) {
            $table->dropColumn('html');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forums_messages', function (Blueprint $table) {
            $table->text('html')->nullable();
        });
    }
}
