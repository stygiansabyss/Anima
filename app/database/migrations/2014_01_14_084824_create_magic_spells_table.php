<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMagicSpellsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magic_spells', function(Blueprint $table) {
			$table->string('uniqueId', 10);
			$table->primary('uniqueId');
			$table->string('magic_tree_id', 10)->index();
			$table->string('attribute_id', 10)->index();
			$table->string('morph_id', 10)->index();
			$table->string('morph_type')->index();
			$table->string('name');
			$table->integer('level');
			$table->string('useCost');
			$table->text('stats')->nullable();
			$table->text('extra')->nullable();
			$table->boolean('approvedFlag')->default(0)->index();
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
		Schema::drop('magic_spells');
	}

}
