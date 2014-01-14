<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharacterDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('character_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('magic_type_id', 10)->index();
			$table->integer('level')->default(3)->nullable();
			$table->integer('experience')->nullable();
			$table->integer('hitPoints');
			$table->integer('tempHitPoints');
			$table->integer('magicPoints')->nullable();
			$table->integer('tempMagicPoints')->nullable();
			$table->integer('gold')->nullable();
			$table->integer('silver')->nullable();
			$table->integer('copper')->nullable();
			$table->text('armorWeapons')->nullable();
			$table->text('generalItems')->nullable();
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
		Schema::drop('character_details');
	}

}
