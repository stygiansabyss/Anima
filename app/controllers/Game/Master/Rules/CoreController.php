<?php

class Game_Master_Rules_CoreController extends Game_Master_RulesController {

	public function getIndex()
	{
		parent::getIndex();

		LeftTab::setHeader('game.master.rules.components.breadcrumbs')
			->addPanel()
				->setTitle('Core Rules')
				->setBasePath('/game/master/rules/core/')
				->addTab('Classes', 'classes')
				->addTab('Appearances', 'appearances')
				->addTab('Base Stats', 'base-stats')
				->addTab('Traits', 'traits')
				->addTab('Attributes', 'attributes')
				->addTab('Secondary Attributes', 'secondary-attributes')
				->addTab('Skills', 'skills')
				->addTab('Magic Types', 'magic-types')
				->buildPanel()
		->make();
	}

	public function getClasses()
	{
		$classes  = Game_Class::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		Crud::setTitle('Classes')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/classdelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($classes);

		// Add the display columns
		Crud::addDisplayField('name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('description', 'textarea');

		Crud::make();
	}

	public function postClasses()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$class                = (isset($input['id']) && $input['id'] != null ? Game_Class::find($input['id']) : new Game_Class);
			$class->name          = $input['name'];
			$class->description   = $input['description'];

			// Attempt to save the object
			$this->save($class);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $class->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getClassdelete($classId)
	{
		$this->skipView();

		$class = Game_Class::find($classId);
		$class->delete();

		return Redirect::to('/game/master/rules/core#classes');
	}

	public function getAppearances()
	{
		$appearances  = Appearance::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		
		Crud::setTitle('Appearances')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/appearancedelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($appearances);

		// Add the display columns
		Crud::addDisplayField('name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postAppearances()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$appearance                = (isset($input['id']) && $input['id'] != null ? Appearance::find($input['id']) : new Appearance);
			$appearance->name          = $input['name'];
			$appearance->description   = $input['description'];

			// Attempt to save the object
			$this->save($appearance);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $appearance->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getAppearancedelete($appearanceId)
	{
		$this->skipView();

		$appearance = Appearance::find($appearanceId);
		$appearance->delete();

		return Redirect::to('/game/master/rules/core#appearances');
	}

	public function getBaseStats()
	{
		$stats  = Stat::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		
		Crud::setTitle('Base Stats')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/basestatdelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($stats);

		// Add the display columns
		Crud::addDisplayField('name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postBaseStats()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$stat                = (isset($input['id']) && $input['id'] != null ? Stat::find($input['id']) : new Stat);
			$stat->name          = $input['name'];
			$stat->description   = $input['description'];

			// Attempt to save the object
			$this->save($stat);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $stat->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getBasestatdelete($statId)
	{
		$this->skipView();

		$stat = Stat::find($statId);
		$stat->delete();

		return Redirect::to('/game/master/rules/core#stats');
	}

	public function getTraits()
	{
		$traits  = Game_Trait::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		
		Crud::setTitle('Advantages/Disadvantages')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/traitdelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($traits);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('type')
				 ->addDisplayField('range');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('minimumValue', 'text')
				 ->addFormField('maximumValue', 'text')
				 ->addFormField('advantageFlag', 'select', array('Disadvantage', 'Advantage'))
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postTraits()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$trait                = (isset($input['id']) && $input['id'] != null ? Game_Trait::find($input['id']) : new Game_Trait);
			$trait->name          = $input['name'];
			$trait->description   = $input['description'];
			$trait->minimumValue  = $input['minimumValue'];
			$trait->maximumValue  = $input['maximumValue'];
			$trait->advantageFlag = $input['advantageFlag'];

			// Attempt to save the object
			$this->save($trait);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $trait->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getTraitdelete($traitId)
	{
		$this->skipView();

		$trait = Game_Trait::find($traitId);
		$trait->delete();

		return Redirect::to('/game/master/rules/core#traits');
	}

	public function getAttributes()
	{
		$attributes  = Attribute::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		
		Crud::setTitle('Attributes')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/attributedelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($attributes);

		// Add the display columns
		Crud::addDisplayField('name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postAttributes()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$attribute               = (isset($input['id']) && $input['id'] != null ? Attribute::find($input['id']) : new Attribute);
			$attribute->name         = $input['name'];
			$attribute->description  = $input['description'];

			// Attempt to save the object
			$this->save($attribute);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $attribute->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getAttributedelete($attributeId)
	{
		$this->skipView();

		$attribute = Attribute::find($attributeId);
		$attribute->delete();

		return Redirect::to('/game/master/rules/core#attributes');
	}

	public function getSecondaryAttributes()
	{
		$secondaryAttributes  = Attribute_Secondary::orderByNameAsc()->paginate(20);

		$attributes     = Attribute::orderByNameAsc()->get();
		$attributeArray = $this->arrayToSelect($attributes, 'id', 'name', 'Select an attribute');

		// Set up the one page crud
		
		Crud::setTitle('Secondary Attributes')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/secondaryattributedelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($secondaryAttributes);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('attribute_name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('attribute_id', 'select', $attributeArray)
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postSecondaryAttributes()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$secondaryAttribute               = (isset($input['id']) && $input['id'] != null ? Attribute_Secondary::find($input['id']) : new Attribute_Secondary);
			$secondaryAttribute->name         = $input['name'];
			$secondaryAttribute->attribute_id = $input['attribute_id'];
			$secondaryAttribute->description  = $input['description'];

			// Attempt to save the object
			$this->save($secondaryAttribute);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $secondaryAttribute->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getSecondaryattributedelete($secondaryAttributeId)
	{
		$this->skipView();

		$secondaryAttribute = Attribute_Secondary::find($secondaryAttributeId);
		$secondaryAttribute->delete();

		return Redirect::to('/game/master/rules/core#secondary-attributes');
	}

	public function getSkills()
	{
		$skills  = Skill::orderByNameAsc()->paginate(20);

		$attributes     = Attribute::orderByNameAsc()->get();
		$attributeArray = $this->arrayToSelect($attributes, 'id', 'name', 'Select an attribute');

		// Set up the one page crud
		
		Crud::setTitle('Skills')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/skilldelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($skills);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('attribute_name');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('attribute_id', 'select', $attributeArray)
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postSkills()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$skill               = (isset($input['id']) && $input['id'] != null ? Skill::find($input['id']) : new Skill);
			$skill->name         = $input['name'];
			$skill->attribute_id = $input['attribute_id'];
			$skill->description  = $input['description'];

			// Attempt to save the object
			$this->save($skill);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $skill->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getSkilldelete($skillId)
	{
		$this->skipView();

		$skill = Skill::find($skillId);
		$skill->delete();

		return Redirect::to('/game/master/rules/core#skills');
	}

	public function getMagicTypes()
	{
		$magicTypes  = Magic_Type::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		
		Crud::setTitle('Magic Types')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/rules/core/magictypedelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($magicTypes);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('user_created_trees');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('userCreatedTreesFlag', 'select', array('No user created trees', 'User\'s can create trees'))
				 ->addFormField('description', 'textarea');

		Crud::make();
		
	}

	public function postMagicTypes()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$magicType                       = (isset($input['id']) && $input['id'] != null ? Magic_Type::find($input['id']) : new Magic_Type);
			$magicType->name                 = $input['name'];
			$magicType->userCreatedTreesFlag = isset($input['userCreatedTreesFlag']) ? 1 : 0;
			$magicType->description          = $input['description'];

			// Attempt to save the object
			$this->save($magicType);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $magicType->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getMagictypedelete($magicTypeId)
	{
		$this->skipView();

		$magicType = Magic_Type::find($magicTypeId);
		$magicType->delete();

		return Redirect::to('/game/master/rules/core#magic-types');
	}
}