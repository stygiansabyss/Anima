<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_items', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->integer('item_rarity_id')->index();
			$table->string('name');
			$table->text('description');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('game_items');
	}

}
