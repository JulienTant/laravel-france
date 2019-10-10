<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('group_id', false, true);
            $table->integer('user_id', false, true);

            $table->foreign('group_id')
                ->references('id')->on('groups')
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
        Schema::drop('group_user');
    }
}
