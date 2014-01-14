<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEnemiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enemies', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('user_id', 10)->index();
			$table->string('parent_id', 10)->index()->nullable();
			$table->string('horde_id', 10)->index()->nullable();
			$table->string('name');
			$table->string('color', 7)->nullable();
			$table->boolean('noExpFlag')->default(0);
			$table->integer('oldId')->index()->nullable();
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
		Schema::drop('enemies');
	}

}
