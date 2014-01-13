<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeadflagToGameCharacters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('characters', function(Blueprint $table) {
			$table->boolean('deadFlag')->default(0)->index()->after('activeFlag');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('characters', function(Blueprint $table) {
			$table->dropColumn('deadFlag');
		});
	}

}
