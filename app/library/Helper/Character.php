<?php

class Helper_Character extends Helper_Forum {

	protected $characters = array();
	protected $enemies = array();
	protected $creatures = array();
	protected $entities = array();

	protected function moveCharactersTable()
	{
		if ($this->confirm('Do you wish to move characters? [yes|no]')) {
			// Move the characters
			$characters = DB::table('stygian_main.characters')->get();

			foreach ($characters as $object) {
				$newObject             = new Character;
				$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
				$newObject->name       = $object->name;
				$newObject->color      = $object->color != null ? $object->color : '#000000';
				$newObject->created_at = $object->created_at;
				$newObject->updated_at = $object->updated_at;
				$newObject->oldId      = $object->id;

				$newObject->save();
			}
			$this->info('Characters moved');
		} else {
			$this->info('Characters skipped');
		}
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

	protected function moveCharacterDetailsTable() {}
	protected function moveEnemyDetailsTable() {}
	protected function moveEntityDetailsTable() {}
	protected function moveCreatureDetailsTable() {}

	protected function moveFFCharacterDetailsTable()
	{
		if ($this->confirm('Do you wish to move character details? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				// Move the characters
				$appearances = DB::table('stygian_main.character_appearance')
								 ->leftJoin('stygian_main.game_template_appearances', 'stygian_main.character_appearance.game_template_appearance_id', '=', 'stygian_main.game_template_appearances.id')
								 ->where('stygian_main.character_appearance.character_id', $character->oldId)
								 ->get();

				$details = array();
				foreach ($appearances as $appearance) {
					if ($appearance->name == 'Appearance') {
						$details['appearance'] = $appearance->value;
					}
					if ($appearance->name == 'Actor') {
						$details['actor'] = $appearance->value;
					}
					if ($appearance->name == 'Known History') {
						$details['knownHistory'] = $appearance->value;
					}
					if ($appearance->name == 'Secret History') {
						$details['secretHistory'] = $appearance->value;
					}
					if ($appearance->name == 'Skill Sets') {
						$details['skillSets'] = $appearance->value;
					}
					if ($appearance->name == 'Flaws') {
						$details['flaws'] = $appearance->value;
					}
					if ($appearance->name == 'Base of Operation') {
						$details['baseOfOperation'] = $appearance->value;
					}
				}

				if (count($details) > 0) {
					foreach ($appearances as $object) {
						$newObject               = new Character_Detail;
						$newObject->character_id = $character->id;

						foreach ($details as $key => $value) {
							$newObject->{$key} = $value;
						}

						$newObject->save();
					}
				}
			}

			$this->info('Character details moved');
		} else {
			$this->info('Character details skipped');
		}
	}
}