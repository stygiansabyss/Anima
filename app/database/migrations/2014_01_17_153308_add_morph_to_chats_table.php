<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMorphToChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chats', function(Blueprint $table) {
			$table->string('morph_id', 10)->index()->nullable();
			$table->string('morph_type')->index()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chats', function(Blueprint $table) {
			$table->dropColumn('morph_id');
			$table->dropColumn('morph_type');
		});
	}

}
