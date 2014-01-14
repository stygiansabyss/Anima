<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharacterTraitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('character_traits', function(Blueprint $table) {
			$table->increments('id');
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('trait_id', 10)->index();
			$table->integer('value')->nullable();
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
		Schema::drop('character_traits');
	}

}
