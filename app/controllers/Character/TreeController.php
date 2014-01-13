<?php

class Character_TreeController extends CharacterController {

	public function getCreate($characterId)
	{
		$character = Character::find($characterId);
		$types     = Magic_Type::where('userCreatedTreesFlag', 1)->orderByNameAsc()->get();

		$types = $this->arrayToSelect($types, 'id', 'name', 'Select a type');

		$this->setViewData('character', $character);
		$this->setViewData('types', $types);
	}

	public function postCreate($characterId)
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			if ($input['name'] == null) {
				Ajax::addError('noname', 'Please submit a name.');
			}
			if ($input['magic_type_id'] == '0') {
				Ajax::addError('noType', 'Please select a magic type.');
			}
			if ($input['description'] == null) {
				Ajax::addError('noDescription', 'Please submit a description.');
			}

			// Check for existing tree
			$tree = Magic_Tree::where('name', $input['name'])->where('magic_type_id', $input['magic_type_id'])->first();

			if ($tree != null) {
				Ajax::addError('existingTree', 'A tree with this name and type already exists.');
			}

			if (Ajax::errorCount() > 0) {
				return Ajax::sendResponse();
			}

			$character = Character::find($characterId);

			$newTree                = new Character_Spell;
			$newTree->morph_type    = 'Character';
			$newTree->morph_id      = $characterId;
			$newTree->name          = $input['name'];
			$newTree->magic_type_id = $input['magic_type_id'];
			$newTree->description   = $input['description'];

			$this->save($newTree);

			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success');
			}

			return Ajax::sendResponse();
		}
	}
}