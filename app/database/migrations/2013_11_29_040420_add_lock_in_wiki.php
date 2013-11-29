<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLockInWiki extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wiki_pages', function(Blueprint $table)
		{
			$table->boolean('lock')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wiki_pages', function(Blueprint $table)
		{
			$table->dropColumn('lock');
		});
	}

}