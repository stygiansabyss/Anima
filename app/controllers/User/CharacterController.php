<?php

class User_CharacterController extends BaseController {

	public function getIndex()
	{
		$rolls = $this->activeUser->rolls;

		$this->setViewData('rolls', $rolls);
	}

	public function getPaginationCharacters()
	{
		$characters = Character::where('user_id', $this->activeUser->id)->orderByNameAsc()->paginate(3);
		$characters->setBaseUrl('/user/characters/pagination-characters');

		$this->setViewData('characters', $characters);
		$this->setViewData('type', 'character');
	}

	public function getPaginationEnemies()
	{
		$enemies = Enemy::where('user_id', $this->activeUser->id)->orderByNameAsc()->paginate(3);
		$enemies->setBaseUrl('/user/characters/pagination-enemies');

		$this->setViewPath('user.character.paginationcharacters');
		$this->setViewData('characters', $enemies);
		$this->setViewData('type', 'enemy');
	}

	public function getGames($characterId)
	{
		$character = Character::find($characterId);
		$games     = Game::orderByNameAsc()->get();

		$this->setViewData('character', $character);
		$this->setViewData('games', $games);
	}

	protected function generateRolls()
	{
		for ($i = 1;$i <= 10;$i++) {
			$roll              = rand(2, 10);

			$newRoll           = new Character_Roll;
			$newRoll->user_id  = $this->activeUser->id;
			$newRoll->roll     = $roll;
			$newRoll->usedFlag = 0;

			$this->save($newRoll);
		}
	}

	public function getRoll()
	{
		// See if the user has an existing set of rolls
		$rolls = $this->activeUser->rolls;

		if ($rolls->count() == 0) {
			$this->generateRolls();

			return $this->redirect('/user/characters', '10 Randonly generated rolls have been created for you.');
		}

		return $this->redirect('/user/characters', 'You already have existing rolls.');
	}

	public function getCreate()
	{
		// CHeck for rolls
		$rolls = $this->activeUser->rolls;

		if ($rolls->count() == 0) {
			$this->generateRolls();

			$rolls = $this->activeUser->rolls;
		}

		// Create the rolls array
		$rollsArray = array(0 => null);
		foreach ($rolls as $roll) {
			$rollsArray[$roll->roll] = $roll->roll;
		}

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

		// Get any data the pages need
		$classArray     = $this->getArray('Game_Class', 'Select a class');
		$magicTypeArray = $this->getArray('Magic_Type', 'None');

		$stats               = Stat::orderByNameAsc()->get();
		$appearances         = Appearance::orderByNameAsc()->get();
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
		$this->setViewData('rolls', $rolls);
		$this->setViewData('rollsArray', $rollsArray);
	}

	public function postCreate()
	{
		$this->skipView();

		$attributes = Input::get('attributes');

		// Make sure the selected stats equal to the rolls the user has
		$rolls          = CoreView::getActiveUser()->rolls->roll->toArray();
		$attributeCheck = array_intersect($rolls, $attributes);

		if (count($attributeCheck) != 10) {
			return $this->redirect('/user/characters/create', 'Your attribute selections do not match your roll.  Please try again.');
		}

		$character = Character::createCharacter(true);

		$this->redirect('/user/characters', $character->name .' created.');
	}

	public function getDelete($characterId)
	{
		$this->skipView();

		$character = Character::find($characterId);
		$character->delete();

		return $this->redirect('back', 'Character deleted.');
	}

}