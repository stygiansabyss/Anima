<?php

class Game_Master_CharacterController extends BaseController {

	public function getCreate($gameId)
	{
		// Set up the wizard required settings
		Wizard::setViewLocation('user.character.create')
			  ->addSteps(array(
					'Basics',
					'Stats',
					'Class',
					'Attributes',
					'Secondary Attributes',
					'Skills',
					'Advantages',
					'Disadvantages',
				)
			);

		// Get any data the pages need
		$classArray     = $this->getArray('Game_Class', 'Select a class');
		$magicTypeArray = $this->getArray('Magic_Type', 'None');

		$stats               = Stat::orderByNameAsc()->get();
		$attributes          = Attribute::orderByNameAsc()->get();
		$secondaryAttributes = Attribute_Secondary::orderByNameAsc()->get();
		$skills              = Skill::orderByNameAsc()->get();
		$advantages          = Game_Trait::advantage()->orderByNameAsc()->get();
		$disadvantages       = Game_Trait::disadvantage()->orderByNameAsc()->get();

		Wizard::make();
		$this->setViewData('classArray', $classArray);
		$this->setViewData('magicTypeArray', $magicTypeArray);
		$this->setViewData('stats', $stats);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('secondaryAttributes', $secondaryAttributes);
		$this->setViewData('skills', $skills);
		$this->setViewData('advantages', $advantages);
		$this->setViewData('disadvantages', $disadvantages);
	}

	public function postCreate($gameId)
	{

	}

	public function getEdit($characterId, $gameId)
	{

	}

	public function postEdit($characterId, $gameId)
	{

	}
}