<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOldIdToGameItemRaritiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('game_item_rarities', function(Blueprint $table) {
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
		Schema::table('game_item_rarities', function(Blueprint $table) {
			$table->dropColumn('oldId');
		});
	}

}
