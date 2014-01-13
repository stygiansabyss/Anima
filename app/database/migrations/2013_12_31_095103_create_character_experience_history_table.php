<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharacterExperienceHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('character_experience_history', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('user_id', 10)->index();
			$table->integer('value');
			$table->text('reason')->nullable();
			$table->string('resource_id', 10)->index()->nullable();
			$table->string('resource_type')->index()->nullable();
			$table->integer('balance');
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
		Schema::drop('character_experience_history');
	}

}
