<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order', false, true)->default(999);
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('background_color');
            $table->string('font_color');
            $table->text('description')->nullable();;

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
        Schema::drop('forums_categories');
    }
}
