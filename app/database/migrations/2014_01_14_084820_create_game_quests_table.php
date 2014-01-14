<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameQuestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_quests', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('game_id', 10)->index();
			$table->string('name');
			$table->text('details');
			$table->text('reward');
			$table->boolean('activeFlag')->default(0)->index();
			$table->boolean('completeFlag')->default(0)->index();
			$table->boolean('incompleteFlag')->default(0)->index();
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
		Schema::drop('game_quests');
	}

}
