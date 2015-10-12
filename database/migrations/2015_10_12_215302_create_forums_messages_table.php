<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums_messages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('forums_topic_id', false, true);
            $table->integer('user_id', false, true);

            $table->text('markdown');
            $table->text('html');

            $table->boolean('solve_topic')->default(false);

            $table->timestamps();

            $table->foreign('forums_topic_id')
                ->references('id')->on('forums_topics')
                ->onDelete('cascade');


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forums_messages');
    }
}
