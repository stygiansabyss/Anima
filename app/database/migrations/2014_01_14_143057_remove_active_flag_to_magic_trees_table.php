<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveActiveFlagToMagicTreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('magic_trees', function(Blueprint $table) {
			$table->dropColumn('activeFlag');
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
			$table->boolean('activeFlag')->default(0);
		});
	}

}
