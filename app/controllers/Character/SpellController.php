<?php

class Character_SpellController extends CharacterController {

	public function getRequest($characterId)
	{
		$character  = Character::find($characterId);

		$magicTypes = Magic_Type::orderByNameAsc()->get();
		$magicTypes = $this->arrayToSelect($magicTypes, 'id', 'name', 'Select a type');

		$this->setViewData('character', $character);
		$this->setViewData('magicTypes', $magicTypes);
	}

	public function postRequest($characterId)
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			if ($input['type_id'] == '0') {
				Ajax::addError('noType', 'Please select a magic type.');
			}
			if ($input['tree_id'] == '0') {
				Ajax::addError('noTree', 'Please select a magic tree.');
			}
			if ($input['spell_id'] == '0') {
				Ajax::addError('noSpell', 'Please select a spell.');
			}
			if ($input['buyCost'] == null) {
				Ajax::addError('noCost', 'Please detail the purchase cost.');
			}
			if ($input['description'] == null) {
				Ajax::addError('noDescription', 'Please detail the description.');
			}

			$character = Character::find($characterId);

			$spellId = $input['spell_id'];

			// Check for existing spell
			$characterSpell = Character_Spell::where('morph_type', 'Character')->where('morph_id', $characterId)->where('magic_spell_id', $spellId)->first();

			if ($characterSpell != null) {
				switch ($characterSpell->approvedFlag) {
					case 1:
						Ajax::addError('previouslyApproved', 'You are already approved to use this spell.');
					break;
					case 0:
						Ajax::addError('previouslyRequested', 'You have already requested access to this spell.');
					break;
				}
			}

			if (Ajax::errorCount() > 0) {
				return Ajax::sendResponse();
			}

			$newCharacterSpell                 = new Character_Spell;
			$newCharacterSpell->morph_type     = 'Character';
			$newCharacterSpell->morph_id       = $characterId;
			$newCharacterSpell->magic_spell_id = $spellId;
			$newCharacterSpell->buyCost        = $input['buyCost'];
			$newCharacterSpell->description    = $input['description'];

			$this->save($newCharacterSpell);

			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success');
			}

			return Ajax::sendResponse();
		}
	}

	public function getCreate($characterId)
	{
		$character  = Character::find($characterId);
		$trees      = Magic_Tree::orderByNameAsc()->get();
		$attributes = Attribute::orderByNameAsc()->get();

		$trees      = $this->arrayToSelect($trees, 'id', 'name', 'Select a tree');
		$attributes = $this->arrayToSelect($attributes, 'id', 'name', 'Select an attribute');

		$this->setViewData('character', $character);
		$this->setViewData('trees', $trees);
		$this->setViewData('attributes', $attributes);
	}

	public function postCreate($characterId)
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			if ($input['name'] == null) {
				Ajax::addError('noname', 'Please submit a name.');
			}
			if ($input['magic_tree_id'] == '0') {
				Ajax::addError('noTree', 'Please select a magic tree.');
			}
			if ($input['attribute_id'] == '0') {
				Ajax::addError('noAttribute', 'Please select an attribute.');
			}
			if ($input['useCost'] == null) {
				Ajax::addError('noCost', 'Please detail the use cost.');
			}
			if ($input['stats'] == null) {
				Ajax::addError('noStats', 'Please detail the stats.');
			}
			if ($input['extra'] == null) {
				Ajax::addError('noExtra', 'Please detail the extra details.');
			}

			// Check for existing spell
			$spell = Magic_Spell::where('name', $input['name'])->where('magic_tree_id', $input['magic_tree_id'])->first();

			if ($spell != null) {
				Ajax::addError('existingSpell', 'A spell with this name and tree already exists.');
			}

			if (Ajax::errorCount() > 0) {
				return Ajax::sendResponse();
			}

			$character = Character::find($characterId);

			$newSpell                = new Character_Spell;
			$newSpell->morph_type    = 'Character';
			$newSpell->morph_id      = $characterId;
			$newSpell->name          = $input['name'];
			$newSpell->level         = $input['level'];
			$newSpell->magic_tree_id = $input['magic_tree_id'];
			$newSpell->attribute_id  = $input['attribute_id'];
			$newSpell->useCost       = $input['useCost'];
			$newSpell->stats         = $input['stats'];
			$newSpell->extra         = $input['extra'];

			$this->save($newSpell);

			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success');
			}

			return Ajax::sendResponse();
		}
	}

	public function getCheckType($typeId)
	{
		return Magic_Type::find($typeId)->toJson();
	}

	public function getCheckTree($treeId)
	{
		return Magic_Tree::find($treeId)->toJson();
	}

	public function getTreeList($typeId, $characterId = null)
	{
		if ($characterId == null) {
			$trees = Magic_Tree::with('type')->where('magic_type_id', $typeId)->where('approvedFlag', 1)->orderByNameAsc()->get();
		} else {
			$trees = Magic_Tree::with('type')->where('magic_type_id', $typeId)->where('approvedFlag', 1)->where('character_id', $characterId)->orderByNameAsc()->get();
		}

		return $trees->toJson();
	}

	public function getSpellList($treeId, $characterId = null)
	{
		if ($characterId == null) {
			$spells = Magic_Spell::with('tree')->where('magic_tree_id', $treeId)->orderByNameAsc()->get();
		} else {
			$spells = Magic_Spell::with('tree')->where('magic_tree_id', $treeId)->where('character_id', $characterId)->orderByNameAsc()->get();
		}
		return $spells->toJson();
	}

	public function getEdit($spellId, $characterId)
	{
		$character = Character::find($characterId);
		$spell     = Character_Spell::find($spellId);

		$this->setViewData('character', $character);
		$this->setViewData('spell', $spell);
	}

	public function postEdit($spellId, $characterId)
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			$spell              = Character_Spell::find($spellId);
			$spell->buyCost     = $input['buyCost'];
			$spell->description = $input['description'];

			$this->checkErrorsSave($spell);

			$this->redirect('/character/spellbook/'. $characterId, 'Spell updated.');
		}
	}

	public function getDelete($spellId, $characterId)
	{
		$this->skipView();

		$spell = Character_Spell::find($spellId);
		$spell->delete();

		$this->redirect('back', 'Spell removed.');
	}
}