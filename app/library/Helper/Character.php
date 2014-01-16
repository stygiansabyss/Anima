<?php

class Helper_Character extends Helper_Forum {

	protected $characters = array(
		'Aliiza Satyxis',
		'Cethin Totemah',
		'Chadrick Tamisier',
		'Luther Nacht',
		'Nora Linhart',
		'Sayuri Takashi',
		'Sera Van Keurlin',
		'Tanith Haritza',
		'Zihao Jeng',
		'Aquamarine Orchard',
		'Asgeir Alfhild',
		'Oswald Ozello',
		'Felix Mordenson',
		'Jaden Fiowen',
		'Raeah Talai',
		'Vashnier Bjorson',
		'Vigdis Úlfa'
	);
	protected $npcs = array(
		'Aaron Normandy',
		'Alastor Lundberg',
		'Arakiel Etemorah',
		'Christian Rousseau',
		'Fabien Cormier',
		'Gabriel Lacroix',
		'Garreth Cormier',
		'Grady Mcleod',
		'Inspector Javert Holt',
		'Jesabel Cormac',
		'Kevin Barr',
		'Kurin El-Sien',
		'Leon Grier',
		'Marian Abernathy',
		'Nidal Hazreen',
		'Overseer Nathaniel',
		'Robin',
		'Sinomen Tate',
		'Trisha Wells',
		'Z\'mara Thushia',
		'Isoba Dia',
		'Kioko Arashi',
		'Osser Jatas',
		'Aliya Otori',
		'Aya Giovanni',
		'Chumana Nightshade',
		'Darrius Rohaan',
		'Jayli Tiberiah',
		'Joe Duncan',
		'Nettle Farseer',
		'Peace Theodor',
		'Rachael Hannigan',
		'Desina Darrin',
		'Marinda Kestrel',
		'Master Jacob',
		'Roselyn Adair'
	);
	protected $enemies = array(
		'Avaritia',
		'Diederik Metzger',
		'Erin Wilder',
		'Ira',
		'Knight Templar',
		'Luxuria',
		'Thug 1',
		'Thug 2',
		'Thug Leader',
		'Tristitia',
		'Baron Gerik',
		'Baron Gizella',
		'Bogill',
		'Flame Turret',
		'Lead Researcher',
		'Researcher',
		'Wissenshaft Guard'
	);
	protected $creatures = array('Aislyn');
	protected $enemyCreatures = array(
		'Cath Flidais (Creature)',
		'Goblin',
		'Goblin Archer Basuxd',
		'Goblin Boss Zxenab (Undead)',
		'Goblin Priest Tkodx',
		'Jungle Panther',
		'Lapsia',
		'Nya Leusi',
		'Nya Leusi - Bajezra',
		'Vampire of Desire',
		'Werewolf Fighter',
		'Werewolf Mage',
		'Werewolf Priest',
		'Zombie',
		'Jack the Steam Golem'
	);
	protected $entities = array(
		'Editor',
		'Narrator',
		'Storyteller',
	);

	protected function moveCharactersTable()
	{
		if ($this->confirm('Do you wish to move characters? [yes|no]')) {
			// Move the characters
			$characters = DB::table('stygian_main.characters')->get();

			foreach ($characters as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					if (in_array($object->name, $this->characters)) {
						$this->movePlayerCharacters($object, $oldGameNewId);
					} elseif (in_array($object->name, $this->npcs)) {
						$this->moveNpcCharacters($object, $oldGameNewId);
					} elseif (in_array($object->name, $this->enemies)) {
						$this->moveEnemies($object, $oldGameNewId);
					} elseif (in_array($object->name, $this->creatures)) {
						$this->moveCreatures($object, $oldGameNewId);
					} elseif (in_array($object->name, $this->enemyCreatures)) {
						$this->moveEnemyCreatures($object, $oldGameNewId);
					} elseif (in_array($object->name, $this->entities)) {
						$this->moveEntities($object);
					} else {
						$this->info($object->name .' with id ('. $object->id .') was not in the list.');
					}
				}
			}
			$this->info('Characters moved');
		} else {
			$this->info('Characters skipped');
		}
	}

	protected function moveCharacterDetailsTable()
	{
		if ($this->confirm('Do you wish to move character details? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertDetails($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertDetails($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertDetails($creature, 'Creature');
			}
			$this->info('Character details moved');
		} else {
			$this->info('Character details skipped');
		}
	}

	protected function moveCharacterClassesTable()
	{
		if ($this->confirm('Do you wish to move character classes? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertClasses($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertClasses($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertClasses($creature, 'Creature');
			}
			$this->info('Character classes moved');
		} else {
			$this->info('Character classes skipped');
		}
	}

	protected function moveCharacterAppearancesTable()
	{
		if ($this->confirm('Do you wish to move character appearances? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertAppearances($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertAppearances($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertAppearances($creature, 'Creature');
			}
			$this->info('Character appearances moved');
		} else {
			$this->info('Character appearances skipped');
		}
	}

	protected function moveCharacterAttributesTable()
	{
		if ($this->confirm('Do you wish to move character attributes? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertAttributes($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertAttributes($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertAttributes($creature, 'Creature');
			}
			$this->info('Character attributes moved');
		} else {
			$this->info('Character attributes skipped');
		}
	}

	protected function moveCharacterEventsTable()
	{
		if ($this->confirm('Do you wish to move character events? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertEvents($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertEvents($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertEvents($creature, 'Creature');
			}
			$this->info('Character events moved');
		} else {
			$this->info('Character events skipped');
		}
	}

	protected function moveCharacterExperienceHistoryTable()
	{
		if ($this->confirm('Do you wish to move character experience history? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertExperienceHistory($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertExperienceHistory($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertExperienceHistory($creature, 'Creature');
			}
			$this->info('Character experience history moved');
		} else {
			$this->info('Character experience history skipped');
		}
	}

	protected function moveCharacterNotesTable()
	{
		if ($this->confirm('Do you wish to move character notes? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertNotes($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertNotes($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertNotes($creature, 'Creature');
			}
			$this->info('Character notes moved');
		} else {
			$this->info('Character notes skipped');
		}
	}

	protected function moveCharacterQuestsTable()
	{
		if ($this->confirm('Do you wish to move character quests? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertQuests($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertQuests($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertQuests($creature, 'Creature');
			}
			$this->info('Character quests moved');
		} else {
			$this->info('Character quests skipped');
		}
	}

	protected function moveCharacterSecondaryAttributesTable()
	{
		if ($this->confirm('Do you wish to move character secondary attributes? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertSecondaryAttributes($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertSecondaryAttributes($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertSecondaryAttributes($creature, 'Creature');
			}
			$this->info('Character secondary attributes moved');
		} else {
			$this->info('Character secondary attributes skipped');
		}
	}

	protected function moveCharacterSkillsTable()
	{
		if ($this->confirm('Do you wish to move character skills? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertSkills($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertSkills($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertSkills($creature, 'Creature');
			}
			$this->info('Character skills moved');
		} else {
			$this->info('Character skills skipped');
		}
	}

	protected function moveCharacterSpellsTable()
	{
		if ($this->confirm('Do you wish to move character spells? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertSpells($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertSpells($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertSpells($creature, 'Creature');
			}
			$this->info('Character spells moved');
		} else {
			$this->info('Character spells skipped');
		}
	}

	protected function moveCharacterStatsTable()
	{
		if ($this->confirm('Do you wish to move character stats? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertStats($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertStats($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertStats($creature, 'Creature');
			}
			$this->info('Character stats moved');
		} else {
			$this->info('Character stats skipped');
		}
	}

	protected function moveCharacterTraitsTable()
	{
		if ($this->confirm('Do you wish to move character traits? [yes|no]')) {
			$characters = Character::all();

			foreach ($characters as $character) {
				$this->convertTraits($character, 'Character');
			}
			$enemies = Enemy::all();

			foreach ($enemies as $enemy) {
				$this->convertTraits($enemy, 'Enemy');
			}
			$creatures = Creature::all();

			foreach ($creatures as $creature) {
				$this->convertTraits($creature, 'Creature');
			}
			$this->info('Character traits moved');
		} else {
			$this->info('Character traits skipped');
		}
	}

	protected function movePlayerCharacters($object, $oldGameNewId)
	{
		$newObject             = new Character;
		$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();

		$this->addCharacterToGame('Character', $newObject->id, $oldGameNewId);
	}

	protected function moveNpcCharacters($object, $oldGameNewId)
	{
		$newObject             = new Character;
		$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();

		$newStatus             = new Character_Status;
		$newStatus->morph_id   = $newObject->id;
		$newStatus->morph_type = 'Character';
		$newStatus->status_id  = 6;

		$newStatus->save();

		$this->addCharacterToGame('Character', $newObject->id, $oldGameNewId);
	}

	protected function moveEnemies($object, $oldGameNewId)
	{
		$newObject             = new Enemy;
		$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();

		$this->addCharacterToGame('Enemy', $newObject->id, $oldGameNewId);
	}
	protected function moveCreatures($object, $oldGameNewId)
	{
		$newObject             = new Creature;
		$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();

		$this->addCharacterToGame('Creature', $newObject->id, $oldGameNewId);
	}
	protected function moveEnemyCreatures($object, $oldGameNewId)
	{
		$newObject             = new Creature;
		$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();

		$newStatus             = new Character_Status;
		$newStatus->morph_id   = $newObject->id;
		$newStatus->morph_type = 'Creature';
		$newStatus->status_id  = 10;

		$newStatus->save();

		$this->addCharacterToGame('Creature', $newObject->id, $oldGameNewId);
	}
	protected function moveEntities($object)
	{
		$newObject             = new Entity;
		$newObject->name       = $object->name;
		$newObject->color      = $object->color != null ? $object->color : '#000000';
		$newObject->created_at = $object->created_at;
		$newObject->updated_at = $object->updated_at;
		$newObject->oldId      = $object->id;

		$newObject->save();
	}

	protected function addCharacterToGame($type, $id, $gameId)
	{
		$characterGame             = new Game_Character;
		$characterGame->game_id    = $gameId;
		$characterGame->morph_id   = $id;
		$characterGame->morph_type = $type;

		$characterGame->save();
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

	protected function convertDetails($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.characters')
						 ->where('stygian_main.characters.id', $character->oldId)
						 ->first();
		$rootInventory = DB::table('stygian_main.character_inventory')
						 ->leftJoin('stygian_main.game_template_inventory', 'stygian_main.character_inventory.game_template_inventory_id', '=', 'stygian_main.game_template_inventory.id')
						 ->where('stygian_main.character_inventory.character_id', $character->oldId)
						 ->get();
		$rootCurrency  = DB::table('stygian_main.character_currency')
						 ->leftJoin('stygian_main.game_template_currency', 'stygian_main.character_currency.game_template_currency_id', '=', 'stygian_main.game_template_currency.id')
						 ->where('stygian_main.character_currency.character_id', $character->oldId)
						 ->get();

		$currency = new Utility_Collection($rootCurrency);
		$gold     = $currency->where('name', 'Gold')->first()->value;
		$currency = new Utility_Collection($rootCurrency);
		$silver   = $currency->where('name', 'Silver')->first()->value;
		$currency = new Utility_Collection($rootCurrency);
		$copper   = $currency->where('name', 'Copper')->first()->value;

		$inventory    = new Utility_Collection($rootInventory);
		$armorWeapons = $inventory->where('name', 'Armor and Weapons')->first()->value;
		$inventory    = new Utility_Collection($rootInventory);
		$generalItems = $inventory->where('name', 'General Items')->first()->value;

		$newObject                  = new Character_Detail;
		$newObject->morph_id        = $character->uniqueId;
		$newObject->morph_type      = $type;
		$newObject->level           = $oldCharacter->level;
		$newObject->experience      = $oldCharacter->experience;
		$newObject->hitPoints       = $oldCharacter->hitPoints;
		$newObject->tempHitPoints   = $oldCharacter->tempHitPoints;
		$newObject->magicPoints     = $oldCharacter->magicPoints;
		$newObject->tempMagicPoints = $oldCharacter->tempMagicPoints;
		$newObject->gold            = $gold;
		$newObject->silver          = $silver;
		$newObject->copper          = $copper;
		$newObject->armorWeapons    = $armorWeapons;
		$newObject->generalItems    = $generalItems;

		$newObject->save();
	}

	protected function convertClasses($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_class')
			->where('stygian_main.character_class.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Class;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->class_id   = $this->getIdForOldId('Game_Class', $oldCharacter->game_template_class_id);
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertAppearances($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_appearance')
			->where('stygian_main.character_appearance.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject                = new Character_Appearance;
			$newObject->morph_id      = $character->uniqueId;
			$newObject->morph_type    = $type;
			$newObject->appearance_id = $this->getIdForOldId('Appearance', $oldCharacter->game_template_appearance_id);
			$newObject->value         = $oldCharacter->value;
			$newObject->created_at    = $oldCharacter->created_at;
			$newObject->updated_at    = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertAttributes($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_attributes')
			->where('stygian_main.character_attributes.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject               = new Character_Attribute;
			$newObject->morph_id     = $character->uniqueId;
			$newObject->morph_type   = $type;
			$newObject->attribute_id = $this->getIdForOldId('Attribute', $oldCharacter->game_template_attribute_id);
			$newObject->value        = $oldCharacter->value;
			$newObject->created_at   = $oldCharacter->created_at;
			$newObject->updated_at   = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertEvents($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.game_history_characters')
			->where('stygian_main.game_history_characters.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Event;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->event_id   = $this->getIdForOldId('Game_Event', $oldCharacter->game_history_id);
			$newObject->experience = $oldCharacter->experience;
			$newObject->note       = $oldCharacter->note;
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertExperienceHistory($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_experience_history')
			->where('stygian_main.character_experience_history.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject                = new Character_Experience_History;
			$newObject->morph_id      = $character->uniqueId;
			$newObject->morph_type    = $type;
			$newObject->user_id       = $this->getIdForOldId('User', $oldCharacter->user_id);
			$newObject->value         = $oldCharacter->value;
			$newObject->reason        = $oldCharacter->reason == 'post' || $oldCharacter->reason == 'reply' ? null : $oldCharacter->reason;
			$newObject->resource_id   = $oldCharacter->resource_id;
			$newObject->resource_type = $oldCharacter->reason == 'post' ? 'Forum_Post' : $oldCharacter->reason == 'reply' ? 'Forum_Reply' : null;
			$newObject->balance       = $oldCharacter->balance;
			$newObject->created_at    = $oldCharacter->created_at;
			$newObject->updated_at    = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertNotes($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_notes')
			->where('stygian_main.character_notes.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Note;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->game_id    = $character->games->game_id->first();
			$newObject->user_id    = $this->getIdForOldId('User', $oldCharacter->user_id);
			$newObject->title      = $oldCharacter->title;
			$newObject->content    = $oldCharacter->content;
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertQuests($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.game_quest_characters')
			->where('stygian_main.game_quest_characters.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Quest;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->quest_id   = $this->getIdForOldId('Game_Quest', $oldCharacter->game_quest_id);
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertSecondaryAttributes($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_secondary_attributes')
			->where('stygian_main.character_secondary_attributes.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject               = new Character_Attribute_Secondary;
			$newObject->morph_id     = $character->uniqueId;
			$newObject->morph_type   = $type;
			$newObject->attribute_id = $this->getIdForOldId('Attribute_Secondary', $oldCharacter->game_template_secondary_attribute_id);
			$newObject->value        = $oldCharacter->value;
			$newObject->created_at   = $oldCharacter->created_at;
			$newObject->updated_at   = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertSkills($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_skills')
			->where('stygian_main.character_skills.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Skill;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->skill_id   = $this->getIdForOldId('Skill', $oldCharacter->game_template_skill_id);
			$newObject->value      = $oldCharacter->value;
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertSpells($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_spells')
			->where('stygian_main.character_spells.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject                 = new Character_Spell;
			$newObject->morph_id       = $character->uniqueId;
			$newObject->morph_type     = $type;
			$newObject->magic_spell_id = $this->getIdForOldId('Magic_Spell', $oldCharacter->game_template_spell_id);
			$newObject->buyCost        = $oldCharacter->buyCost;
			$newObject->description    = $oldCharacter->description;
			$newObject->approvedFlag   = $oldCharacter->approvedFlag;
			$newObject->created_at     = $oldCharacter->created_at;
			$newObject->updated_at     = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertStats($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_stats')
			->where('stygian_main.character_stats.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Stat;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->stat_id    = $this->getIdForOldId('Stat', $oldCharacter->game_template_base_stat_id);
			$newObject->value      = $oldCharacter->value;
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}

	protected function convertTraits($character, $type)
	{
		$oldCharacter  = DB::table('stygian_main.character_traits')
			->where('stygian_main.character_traits.character_id', $character->oldId)
			->first();

		if (!is_null($oldCharacter)) {
			$newObject             = new Character_Trait;
			$newObject->morph_id   = $character->uniqueId;
			$newObject->morph_type = $type;
			$newObject->trait_id    = $this->getIdForOldId('Game_Trait', $oldCharacter->game_template_trait_id);
			$newObject->value      = $oldCharacter->value;
			$newObject->created_at = $oldCharacter->created_at;
			$newObject->updated_at = $oldCharacter->updated_at;

			$newObject->save();
		}
	}
}