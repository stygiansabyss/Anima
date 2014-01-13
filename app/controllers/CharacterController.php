<?php

class CharacterController extends BaseController {

	public function getSheet($characterId)
	{
		$character = Character::find($characterId);

		$this->setViewData('character', $character);
	}

	public function getSpellbook($characterId)
	{
		$character = Character::find($characterId);

		$characterSpells = Character_Spell::where('morph_id', $characterId)->where('morph_type', 'Character')->paginate(20);

		$this->setViewData('character', $character);
		$this->setViewData('characterSpells', $characterSpells);
	}
}