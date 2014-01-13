<?php
 
class BaseModel extends Core_BaseModel {
 
    /********************************************************************
     * Core
     *******************************************************************/
    const ROLE_DEVELOPER   = 2;
    const ROLE_GUEST       = 3;
    const ROLE_FORUM_ADMIN = 5;
    const ROLE_SITE_ADMIN  = 1;

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/

	public static function createCharacter($forcedRolls = false)
	{
		$class = get_called_class();

		$character               = new $class;
		$character->user_id      = CoreView::getActiveUser()->id;
		$character->name         = Input::get('name');
		$character->color        = Input::get('color');
		$character->hiddenFlag   = Input::has('hiddenFlag') ? 1 : 0;
		$character->activeFlag   = Input::has('activeFlag') ? 1 : 0;
		$character->approvedFlag = 0;
		if ($class == 'Enemy') {
			$character->noExpFlag  = Input::has('noExpFlag') ? 1 : 0;
		}

		$character->save();

		// Handle the details
		$details                  = new Character_Detail;
		$details->morph_id        = $character->id;
		$details->morph_type      = $class;
		$details->magic_type_id   = Input::get('magic_type_id');
		$details->level           = Input::get('level');
		$details->experience      = Input::get('experience');
		$details->hitPoints       = Input::get('hitPoints');
		$details->tempHitPoints   = Input::get('hitPoints');
		$details->magicPoints     = Input::get('magicPoints');
		$details->tempMagicPoints = Input::get('magicPoints');

		$details->save();

		// Handle the avatar
		if (Input::hasFile('avatar')) {
			CoreImage::addImage(public_path() .'/img/avatars/'. $class .'/', Input::file('avatar'), Str::studly($character->name));
		}

		// Set the class
		$characterClass             = new Character_Class;
		$characterClass->morph_id   = $character->id;
		$characterClass->morph_type = $class;
		$characterClass->class_id   = Input::get('class_id');

		$characterClass->save();

		$stats               = Input::get('stats');
		$appearances         = Input::get('appearances');
		$attributes          = Input::get('attributes');
		$secondaryAttributes = Input::get('secondaryAttributes');
		$skills              = Input::get('skills');
		$traits              = Input::get('traits');

		// Handle the base stats
		foreach ($stats as $statId => $value) {
			$characterStat             = new Character_Stat;
			$characterStat->morph_id   = $character->id;
			$characterStat->morph_type = $class;
			$characterStat->stat_id    = $statId;
			$characterStat->value      = $value;

			$characterStat->save();
		}

		// Handle the appearances
		foreach ($appearances as $appearanceId => $value) {
			$characterAppearance                = new Character_Appearance;
			$characterAppearance->morph_id      = $character->id;
			$characterAppearance->morph_type    = $class;
			$characterAppearance->appearance_id = $appearanceId;
			$characterAppearance->value         = $value;

			$characterAppearance->save();
		}

		// Handle the attributes
		foreach ($attributes as $attributeId => $value) {
			$characterAttribute               = new Character_Attribute;
			$characterAttribute->morph_id     = $character->id;
			$characterAttribute->morph_type   = $class;
			$characterAttribute->attribute_id = $attributeId;
			$characterAttribute->value        = $value;

			$characterAttribute->save();
		}

		// Handle the secondary attributes
		foreach ($secondaryAttributes as $attributeId => $value) {
			$characterAttribute               = new Character_Attribute_Secondary;
			$characterAttribute->morph_id     = $character->id;
			$characterAttribute->morph_type   = $class;
			$characterAttribute->attribute_id = $attributeId;
			$characterAttribute->value        = $value;

			$characterAttribute->save();
		}

		// Handle the skills
		foreach ($skills as $skillId => $value) {
			$characterSkill             = new Character_Skill;
			$characterSkill->morph_id   = $character->id;
			$characterSkill->morph_type = $class;
			$characterSkill->skill_id   = $skillId;
			$characterSkill->value      = $value;

			$characterSkill->save();
		}

		// Handle the traits
		foreach ($traits as $traitId => $value) {
			$characterTrait             = new Character_Trait;
			$characterTrait->morph_id   = $character->id;
			$characterTrait->morph_type = $class;
			$characterTrait->trait_id   = $traitId;
			$characterTrait->value      = $value;

			$characterTrait->save();
		}

		return $character;
	}
}