<?php

class CharacterController extends BaseController {

	public function getSheet($characterId)
	{
		$character = Character::find($characterId);

		$this->setViewData('character', $character);
	}

	public function getSheetBeta($characterId)
	{
		$character = Character::find($characterId);
		$attributes = Attribute::orderByNameAsc()->get();
		$skills = Skill::orderByNameAsc()->get();

		$this->setViewData('character', $character);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('skills', $skills);
	}

	public function getSpellbook($characterId)
	{
		$character = Character::find($characterId);

		$characterSpells = Character_Spell::where('morph_id', $characterId)->where('morph_type', 'Character')->paginate(20);

		$this->setViewData('character', $character);
		$this->setViewData('characterSpells', $characterSpells);
	}
}