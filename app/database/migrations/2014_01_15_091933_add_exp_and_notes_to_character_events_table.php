<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddExpAndNotesToCharacterEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('character_events', function(Blueprint $table) {
			$table->integer('experience')->nullable();
			$table->text('note')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('character_events', function(Blueprint $table) {
			$table->dropColumn('experience');
			$table->dropColumn('note');
		});
	}

}
