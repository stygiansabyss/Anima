<?php

class Game_Master_EnemyController extends BaseController {

	public function getCreate($gameId)
	{
		// Set up the wizard required settings
		Wizard::setViewLocation('user.character.create')
			  ->addSteps(array(
					'Basics',
					'Appearances',
					'Stats',
					'Class',
					'Attributes',
					'Secondary Attributes',
					'Skills',
					'Advantages',
					'Disadvantages',
				)
			);

		// Create the rolls array
		$rollsArray = range(1, 10);

		// Get any data the pages need
		$classArray     = $this->getArray('Game_Class', 'Select a class');
		$magicTypeArray = $this->getArray('Magic_Type', 'None');

		$appearances         = Appearance::orderByNameAsc()->get();
		$stats               = Stat::orderByNameAsc()->get();
		$attributes          = Attribute::orderByNameAsc()->get();
		$secondaryAttributes = Attribute_Secondary::orderByNameAsc()->get();
		$skills              = Skill::orderByNameAsc()->get();
		$advantages          = Game_Trait::advantage()->orderByNameAsc()->get();
		$disadvantages       = Game_Trait::disadvantage()->orderByNameAsc()->get();

		Wizard::make();

		$this->setViewData('classArray', $classArray);
		$this->setViewData('magicTypeArray', $magicTypeArray);
		$this->setViewData('appearances', $appearances);
		$this->setViewData('stats', $stats);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('secondaryAttributes', $secondaryAttributes);
		$this->setViewData('skills', $skills);
		$this->setViewData('advantages', $advantages);
		$this->setViewData('disadvantages', $disadvantages);
		$this->setViewData('rolls', $rollsArray);
	}

	public function postCreate($gameId)
	{
		Enemy::createCharacter();
		ppd('did not create');
		$input = e_array(Input::all());

		if ($input != null) {
			ppd($input);
			// Handle the enemy itself
			$enemy             = new Enemy;
			$enemy->name       = $input['name'];
			$enemy->color      = $input['color'];
			$enemy->hiddenFlag = isset($input['hiddenFlag']) ? 1 : 0;
			$enemy->activeFlag = isset($input['activeFlag']) ? 1 : 0;
			$enemy->noExpFlag  = isset($input['noExpFlag']) ? 1 : 0;

			$this->checkErrorsSave($enemy);

			// Handle the details
			$details                  = new Character_Details;
			$details->morph_id        = $enemy->id;
			$details->morph_type      = 'Enemy';
			$details->magic_type_id   = $input['magic_type_id'];
			$details->level           = $input['level'];
			$details->experience      = $input['experience'];
			$details->hitPoints       = $input['hitPoints'];
			$details->tempHitPoints   = $input['hitPoints'];
			$details->magicPoints     = $input['magicPoints'];
			$details->tempMagicPoints = $input['magicPoints'];

			$this->save($details);

			// Handle the base stats
			foreach ($input['stats'] as $statId => $value) {
				$enemyStat             = new Character_Stat;
				$enemyStat->morph_id   = $enemy->id;
				$enemyStat->morph_type = 'Enemy';
				$enemyStat->stat_id    = $statId;
				$enemyStat->value      = $value;

				$this->save($enemyStat);
			}

			// Set the class
			$class             = new Character_Class;
			$class->morph_id   = $enemy->id;
			$class->morph_type = 'Enemy';
			$class->class_id   = $input['class_id'];

			$this->save($class);

			// Handle the attributes
			foreach ($input['attributes'] as $attributeId => $value) {
				$enemyAttribute               = new Character_Attribute;
				$enemyAttribute->morph_id     = $enemy->id;
				$enemyAttribute->morph_type   = 'Enemy';
				$enemyAttribute->attribute_id = $attributeId;
				$enemyAttribute->value        = $value;

				$this->save($enemyAttribute);
			}

			// Handle the secondary attributes
			foreach ($input['secondaryAttributes'] as $attributeId => $value) {
				$enemyAttribute               = new Character_Attribute_Secondary;
				$enemyAttribute->morph_id     = $enemy->id;
				$enemyAttribute->morph_type   = 'Enemy';
				$enemyAttribute->attribute_id = $attributeId;
				$enemyAttribute->value        = $value;

				$this->save($enemyAttribute);
			}

			// Handle the skills
			foreach ($input['skills'] as $skillId => $value) {
				$enemySkill             = new Character_Skill;
				$enemySkill->morph_id   = $enemy->id;
				$enemySkill->morph_type = 'Enemy';
				$enemySkill->skill_id   = $skillId;
				$enemySkill->value      = $value;

				$this->save($enemySkill);
			}

			// Handle the traits
			foreach ($input['traits'] as $traitId => $value) {
				$enemyTrait             = new Character_Trait;
				$enemyTrait->morph_id   = $enemy->id;
				$enemyTrait->morph_type = 'Enemy';
				$enemyTrait->trait_id   = $traitId;
				$enemyTrait->value      = $value;

				$this->save($enemyTrait);
			}

			// Handle the avatar
			if (Input::hasFile('avatar')) {
				CoreImage::addImage(public_path() .'/img/avatars/Enemy', Input::file('avatar'), Str::studly($enemy->name));
				$imageErrors = CoreImage::getErrors();

				if (count($imageErrors) > 0) {
					$this->addErrors($imageErrors);
				}
			}
		}
	}

	public function getEdit($characterId, $gameId)
	{

	}

	public function postEdit($characterId, $gameId)
	{
		$input = e_array(Input::all());

		if ($input != null) {
			// Handle the avatar
			if (Input::hasFile('avatar')) {
				CoreImage::addImage(public_path() .'/img/avatars/Enemy', Input::file('avatar'), Str::studly($enemy->name));
				$imageErrors = CoreImage::getErrors();

				if (count($imageErrors) > 0) {
					$this->addErrors($imageErrors);
				}
			}
		}
	}
}