<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiversionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wiki_versions', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('wiki_page_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('version')->unsigned();
            $table->string('title');
            $table->text('content');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wiki_page_id')->references('id')->on('wiki_pages');

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
		Schema::drop('wiki_versions');
	}

}
