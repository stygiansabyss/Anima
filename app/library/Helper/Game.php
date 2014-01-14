<?php

class Helper_Game extends Helper_User {

	protected function moveGameTable()
	{
		if ($this->confirm('Do you wish to move games? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.games')->where('game_template_id', 1)->get();

			foreach ($objects as $object) {
				$newObject              = new Game;
				$newObject->name        = $object->name;
				$newObject->keyName     = Str::studly($object->name);
				$newObject->description = $object->description;
				$newObject->activeFlag  = $object->activeFlag;
				$newObject->created_at  = $object->created_at;
				$newObject->updated_at  = $object->updated_at;
				$newObject->oldId       = $object->id;

				$newObject->save();
			}
			$this->info('Games moved');
		} else {
			$this->info('Games skipped');
		}
	}

	protected function moveGameStoryTellers()
	{
		if ($this->confirm('Do you wish to move story-tellers? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_storytellers')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject              = new Game_Storyteller;
					$newObject->game_id        = $oldGameNewId;
					$newObject->user_id     = $this->getIdForOldId('User', $object->user_id);
					$newObject->created_at  = $object->created_at;
					$newObject->updated_at  = $object->updated_at;

					$newObject->save();
				}
			}
			$this->info('Story-Tellers moved');
		} else {
			$this->info('Story-Tellers skipped');
		}
	}

	protected function moveAttributesTable()
	{
		if ($this->confirm('Do you wish to move the attributes? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_attributes')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject              = new Attribute;
					$newObject->name        = $object->name;
					$newObject->description = $object->description;
					$newObject->created_at  = $object->created_at;
					$newObject->updated_at  = $object->updated_at;
					$newObject->oldId       = $object->id;

					$newObject->save();
				}
			}
			$this->info('Attributes moved');
		} else {
			$this->info('Attributes skipped');
		}
	}

	protected function moveAttributeModifiersTable()
	{
		if ($this->confirm('Do you wish to move the attribute modifiers? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_template_attribute_modifiers')->get();

			foreach ($objects as $object) {
				$newObject             = new Attribute_Modifier;
				$newObject->value      = $object->value;
				$newObject->modifier   = $object->modifier;
				$newObject->created_at = $object->created_at;
				$newObject->updated_at = $object->updated_at;

				$newObject->save();
			}
			$this->info('Attribute modifiers moved');
		} else {
			$this->info('Attribute modifiers skipped');
		}
	}

	protected function moveAppearancesTable()
	{
		if ($this->confirm('Do you wish to move the appearances? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_appearance')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject              = new Appearance;
					$newObject->name        = $object->name;
					$newObject->description = $object->description;
					$newObject->created_at  = $object->created_at;
					$newObject->updated_at  = $object->updated_at;
					$newObject->oldId       = $object->id;

					$newObject->save();
				}
			}
			$this->info('Appearances moved');
		} else {
			$this->info('Appearances skipped');
		}
	}

	protected function moveSecondaryAttributesTable()
	{
		if ($this->confirm('Do you wish to move the secondary attributes? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_secondary_attributes')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject               = new Attribute_Secondary;
					$newObject->attribute_id = $this->getIdForOldId('Attribute', $object->game_attribute_id);
					$newObject->name         = $object->name;
					$newObject->description  = $object->description;
					$newObject->created_at   = $object->created_at;
					$newObject->updated_at   = $object->updated_at;
					$newObject->oldId        = $object->id;

					$newObject->save();
				}
			}
			$this->info('Secondary Attributes moved');
		} else {
			$this->info('Secondary Attributes skipped');
		}
	}

	protected function moveSkillsTable()
	{
		if ($this->confirm('Do you wish to move the skills? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_skills')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject               = new Skill;
					$newObject->attribute_id = $this->getIdForOldId('Attribute', $object->game_attribute_id);
					$newObject->name         = $object->name;
					$newObject->description  = $object->description;
					$newObject->created_at   = $object->created_at;
					$newObject->updated_at   = $object->updated_at;
					$newObject->oldId        = $object->id;

					$newObject->save();
				}
			}
			$this->info('Skills moved');
		} else {
			$this->info('Skills skipped');
		}
	}

	protected function moveStatsTable()
	{
		if ($this->confirm('Do you wish to move the stats? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_base_stats')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject               = new Stat;
					$newObject->name         = $object->name;
					$newObject->description  = $object->description;
					$newObject->created_at   = $object->created_at;
					$newObject->updated_at   = $object->updated_at;
					$newObject->oldId        = $object->id;

					$newObject->save();
				}
			}
			$this->info('Stats moved');
		} else {
			$this->info('Stats skipped');
		}
	}

	protected function moveTraitsTable()
	{
		if ($this->confirm('Do you wish to move the traits? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_template_traits')->get();

			foreach ($objects as $object) {
				$newObject                = new Game_Trait;
				$newObject->name          = $object->name;
				$newObject->description   = $object->description;
				$newObject->minimumValue  = $object->minimumValue;
				$newObject->maximumValue  = $object->maximumValue;
				$newObject->advantageFlag = $object->advantageFlag;
				$newObject->created_at    = $object->created_at;
				$newObject->updated_at    = $object->updated_at;
				$newObject->oldId         = $object->id;

				$newObject->save();
			}
			$this->info('Traits moved');
		} else {
			$this->info('Traits skipped');
		}
	}

	protected function moveClassesTable()
	{
		if ($this->confirm('Do you wish to move the classes? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_classes')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject               = new Game_Class;
					$newObject->name         = $object->name;
					$newObject->description  = $object->description;
					$newObject->created_at   = $object->created_at;
					$newObject->updated_at   = $object->updated_at;
					$newObject->oldId        = $object->id;

					$newObject->save();
				}
			}
			$this->info('Classes moved');
		} else {
			$this->info('Classes skipped');
		}
	}

	protected function moveGameEventsTable()
	{
		if ($this->confirm('Do you wish to move the events? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_history')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject             = new Game_Event;
					$newObject->game_id    = $oldGameNewId;
					$newObject->week       = date('Y-m-d', strtotime($object->week));
					$newObject->details    = $object->details;
					$newObject->created_at = $object->created_at;
					$newObject->updated_at = $object->updated_at;
					$newObject->oldId      = $object->id;

					$newObject->save();
				}
			}
			$this->info('Events moved');
		} else {
			$this->info('Events skipped');
		}
	}

	protected function moveGameItemRarities()
	{
		if ($this->confirm('Do you wish to move the item rarities? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_item_rarities')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject             = new Item_Rarity;
					$newObject->name       = $object->name;
					$newObject->color      = '#ffffff';
					$newObject->created_at = $object->created_at;
					$newObject->updated_at = $object->updated_at;
					$newObject->oldId      = $object->id;

					$newObject->save();
				}
			}
			$this->info('Item rarities moved');
		} else {
			$this->info('Item rarities skipped');
		}
	}

	protected function moveGameItems()
	{
		if ($this->confirm('Do you wish to move the items? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_items')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					if ($object->game_item_rarity_id > 4) {
						$object->game_item_rarity_id = $object->game_item_rarity_id -4;
					}
					$newObject                 = new Item;
					$newObject->item_rarity_id = $this->getIdForOldId('Item_Rarity', $object->game_item_rarity_id);
					$newObject->name           = $object->name;
					$newObject->description    = $object->description;
					$newObject->created_at     = $object->created_at;
					$newObject->updated_at     = $object->updated_at;
					$newObject->oldId          = $object->id;

					$newObject->save();
				}
			}
			$this->info('Items moved');
		} else {
			$this->info('Items skipped');
		}
	}

	protected function moveGameQuests()
	{
		if ($this->confirm('Do you wish to move the quests? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_quests')->get();

			foreach ($objects as $object) {
				// Get the old game ID
				$oldGameNewId = $this->getIdForOldId('Game', $object->game_id);

				if ($oldGameNewId != '0') {
					$newObject                 = new Game_Quest;
					$newObject->game_id        = $oldGameNewId;
					$newObject->name           = $object->name;
					$newObject->details        = $object->details;
					$newObject->reward         = $object->reward;
					$newObject->activeFlag     = $object->activeFlag;
					$newObject->completeFlag   = $object->completeFlag;
					$newObject->incompleteFlag = $object->incompleteFlag;
					$newObject->created_at     = $object->created_at;
					$newObject->updated_at     = $object->updated_at;
					$newObject->oldId          = $object->id;

					$newObject->save();
				}
			}
			$this->info('Quests moved');
		} else {
			$this->info('Quests skipped');
		}
	}

	protected function moveMagicTypesTable()
	{
		if ($this->confirm('Do you wish to move the magic types? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_template_magic_types')->get();

			foreach ($objects as $object) {
				$newObject                       = new Magic_Type;
				$newObject->name                 = $object->name;
				$newObject->description          = $object->description;
				$newObject->userCreatedTreesFlag = $object->userCreatedTreesFlag;
				$newObject->created_at           = $object->created_at;
				$newObject->updated_at           = $object->updated_at;
				$newObject->oldId                = $object->id;

				$newObject->save();
			}
			$this->info('Magic types moved');
		} else {
			$this->info('Magic types skipped');
		}
	}

	protected function moveMagicTreesTable()
	{
		if ($this->confirm('Do you wish to move the magic trees? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_template_magic_trees')->get();

			foreach ($objects as $object) {
				$newObject                = new Magic_Tree;
				$newObject->magic_type_id = $this->getIdForOldId('Magic_Type', $object->game_template_magic_type_id);
				$newObject->name          = $object->name;
				$newObject->description   = $object->description;
				$newObject->approvedFlag  = $object->approvedFlag;
				$newObject->created_at    = $object->created_at;
				$newObject->updated_at    = $object->updated_at;
				$newObject->oldId         = $object->id;

				$newObject->save();
			}
			$this->info('Magic trees moved');
		} else {
			$this->info('Magic trees skipped');
		}
	}

	protected function moveMagicSpellsTable()
	{
		if ($this->confirm('Do you wish to move the magic spells? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.game_template_spells')->get();

			foreach ($objects as $object) {
				$newObject                = new Magic_Spell;
				$newObject->magic_tree_id = $this->getIdForOldId('Magic_Tree', $object->game_template_magic_tree_id);
				$newObject->attribute_id  = $this->getIdForOldId('Attribute', $object->game_template_attribute_id);
				$newObject->name          = $object->name;
				$newObject->level         = $object->level;
				$newObject->useCost       = $object->useCost;
				$newObject->stats         = $object->stats;
				$newObject->extra         = $object->extra;
				$newObject->approvedFlag  = $object->approvedFlag;
				$newObject->created_at    = $object->created_at;
				$newObject->updated_at    = $object->updated_at;
				$newObject->oldId         = $object->id;

				$newObject->save();
			}
			$this->info('Magic spells moved');
		} else {
			$this->info('Magic spells skipped');
		}
	}
}