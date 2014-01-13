<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterValueColumnOnCharacterAppearancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('character_appearances', function(Blueprint $table) {
			$table->dropColumn('value');
			$table->text('value')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('character_appearances', function(Blueprint $table) {
			$table->dropColumn('value');
			$table->string('value')->nullable();
		});
	}

}
