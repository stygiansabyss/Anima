<?php

class Game_Master_RulesController extends BaseController {

	public $magicType = null;

	public $areaName  = null;

	public function getIndex()
	{
		if ($this->magicType != null) {
			LeftTab::setHeader('game.master.rules.components.breadcrumbs');

			$leftTabPanel = LeftTab::addPanel();
			$leftTabPanel->setTitle($this->areaName);

			$typeMagic  = Magic_Type::where('name', $this->magicType)->first();
			$magicTrees = $typeMagic->trees;

			$leftTabPanel->addTab($this->magicType .' Trees', 'trees');

			foreach ($magicTrees as $magicTree) {
				$leftTabPanel->addTab($magicTree->name, 'spells/'. $magicTree->id);
			}

			return $leftTabPanel->buildPanel();
		}
	}

	public function getTrees()
	{
		$typeMagic  = Magic_Type::where('name', $this->magicType)->first();
		$trees      = $typeMagic->trees;

		// Set up the one page crud
		Crud::setTitle('Magic Trees')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/treedelete/')
				 ->setDeleteProperty('id')
				 ->setResources($trees);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('character_created')
				 ->addDisplayField('approved');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('description', 'textarea');

		Crud::make();
	}

	public function postTrees()
	{
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$tree               = (isset($input['id']) && $input['id'] != null ? Magic_Tree::find($input['id']) : new Magic_Tree);
			$tree->name         = $input['name'];
			$tree->description  = $input['description'];

			// Attempt to save the object
			$this->save($tree);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $tree->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getTreedelete($treeId)
	{
		$this->skipView();

		$tree = Magic_Tree::find($treeId);
		$tree->delete();

		$this->redirect('back', 'Tree deleted.');
	}

	public function getSpells($treeId)
	{
		$tree   = Magic_Tree::find($treeId);
		$spells = Magic_Spell::where('magic_tree_id', $treeId)->orderByNameAsc()->paginate(20);

		$attributes = Attribute::orderByNameAsc()->get();
		$attributeArray = $this->arrayToSelect($attributes, 'id', 'name', 'Select an Attribute');

		// Set up the one page crud
		Crud::setTitle($tree->name .' Spells')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/spelldelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($spells);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('attribute_name')
				 ->addDisplayField('level')
				 ->addDisplayField('useCost');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('attribute_id', 'select', $attributeArray)
				 ->addFormField('level', 'text')
				 ->addFormField('useCost', 'text')
				 ->addFormField('stats', 'textarea')
				 ->addFormField('extra', 'textarea')
				 ->addFormField('creatureFlag', 'select', array('Not a creature spell', 'Creature Spell'));

		Crud::make();
	}

	public function postSpells($treeId)
	{
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$spell                = (isset($input['id']) && $input['id'] != null ? Magic_Spell::find($input['id']) : new Magic_Spell);
			$spell->name          = $input['name'];
			$spell->magic_tree_id = $treeId;
			$spell->attribute_id  = $input['attribute_id'];
			$spell->level         = $input['level'];
			$spell->useCost       = $input['useCost'];
			$spell->stats         = $input['stats'];
			$spell->extra         = $input['extra'];
			$spell->creatureFlag  = $input['creatureFlag'];

			// Attempt to save the object
			$this->save($spell);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $spell->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getSpelldelete($spellId)
	{
		$this->skipView();

		$spell = Magic_Spell::find($spellId);
		$spell->delete();

		$this->redirect('back', 'Spell deleted.');
	}

}