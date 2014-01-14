<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('creatures', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('user_id', 10)->index();
			$table->string('parent_id', 10)->index()->nullable();
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('name');
			$table->string('color', 7)->nullable();
			$table->string('category');
			$table->boolean('noExpFlag')->default(1);
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
		Schema::drop('creatures');
	}

}
