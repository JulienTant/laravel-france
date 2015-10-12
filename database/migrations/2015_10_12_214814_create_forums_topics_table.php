<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums_topics', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('forums_category_id', false, true);
            $table->integer('user_id', false, true);
            $table->boolean('sticky')->default(0);
            $table->string('title');
            $table->string('slug');
            $table->boolean('solved')->default(0);
            $table->integer('solved_by')->unsigned()->nullable();
            $table->integer('last_message_id')->unsigned()->nullable();

            $table->timestamps();


            $table->foreign('forums_category_id')
                ->references('id')->on('forums_categories')
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
        Schema::drop('forums_topics');
    }
}
