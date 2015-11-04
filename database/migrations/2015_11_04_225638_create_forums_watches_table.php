<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsWatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums_watches', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('forums_topic_id', false, true);
            $table->integer('user_id', false, true);

            $table->boolean('is_up_to_date')->default(true);

            $table->foreign('forums_topic_id')
                ->references('id')->on('forums_topics')
                ->onDelete('cascade');


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forums_watches');
    }
}
