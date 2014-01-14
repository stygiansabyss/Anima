<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameStorytellersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_storytellers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('game_id', 10)->index();
			$table->string('user_id', 10)->index();
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
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
		Schema::drop('game_storytellers');
	}

}
