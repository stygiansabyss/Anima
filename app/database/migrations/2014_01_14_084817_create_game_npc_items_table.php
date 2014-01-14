<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameNpcItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_npc_items', function(Blueprint $table) {
			$table->increments('id');
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('item_id', 10)->index();
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
		Schema::drop('game_npc_items');
	}

}
