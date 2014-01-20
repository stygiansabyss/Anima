<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddGameIdToChatRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chat_rooms', function(Blueprint $table) {
			$table->string('game_id', 10)->index()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chat_rooms', function(Blueprint $table) {
			$table->dropColumn('game_id');
		});
	}

}
