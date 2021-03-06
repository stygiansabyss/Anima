<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppearancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appearances', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('name');
			$table->text('description');
			$table->boolean('creatureFlag')->default(0)->index();
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
		Schema::drop('appearances');
	}

}
