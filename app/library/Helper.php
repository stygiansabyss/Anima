<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Helper extends Command {

	protected function addOldIdColumn($tableName)
	{
		if (!Schema::hasColumn($tableName, 'oldId')) {
			Schema::table($tableName, function(Blueprint $table) {
				$table->integer('oldId')->index();
			});
		}
	}

	protected function getIdForOldId($class, $oldId)
	{
		$object = $class::where('oldId', $oldId)->first();

		if ($object == null) {
			return 0;
		}

		return $object->id;
	}
}