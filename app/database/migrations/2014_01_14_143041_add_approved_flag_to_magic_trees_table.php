<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddApprovedFlagToMagicTreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('magic_trees', function(Blueprint $table) {
			$table->boolean('approvedFlag')->default(0);
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
			$table->dropColumn('approvedFlag');
		});
	}

}
