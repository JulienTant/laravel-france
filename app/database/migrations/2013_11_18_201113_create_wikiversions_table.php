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
            $table->integer('version')->unsigned();
            $table->text('content');

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
