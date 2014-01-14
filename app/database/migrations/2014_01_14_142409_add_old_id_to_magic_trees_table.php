<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOldIdToMagicTreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('magic_trees', function(Blueprint $table) {
			$table->integer('oldId')->index()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('magic_trees', function(Blueprint $table) {
			$table->dropColumn('oldId');
		});
	}

}
