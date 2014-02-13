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

	protected function findCharacterById($characterId)
	{
		// Check characters first
		$character = Character::where('oldId', $characterId)->first();

		if (!is_null($character)) return $character;

		// Check enemies
		$enemy = Enemy::where('oldId', $characterId)->first();

		if (!is_null($enemy)) return $enemy;

		// Check entities
		$entity = Entity::where('oldId', $characterId)->first();

		if (!is_null($entity)) return $entity;

		// Check creatures
		$creature = Creature::where('oldId', $characterId)->first();

		if (!is_null($creature)) return $creature;

		return null;
	}
}