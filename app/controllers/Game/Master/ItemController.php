<?php

class Game_Master_ItemController extends Game_Master_RulesController {

	public function getIndex()
	{
		LeftTab::
			addPanel()
				->setTitle('Items')
				->setBasePath('/game/master/items/')
				->addTab('Item Rarities', 'item-rarities')
				->addTab('Items', 'items')
				->buildPanel()
			->setHeader('game.master.rules.components.breadcrumbs')
			->setDefaultTab(2)
		->make();
	}

	public function getItemRarities()
	{
		$rarities  = Item_Rarity::orderByNameAsc()->paginate(20);

		// Set up the one page crud
		Crud::setTitle('Item Rarities')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/items/raritydelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($rarities);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('color');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('color', 'text');

		Crud::make();
	}

	public function postItemRarities()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$rarity        = (isset($input['id']) && $input['id'] != null ? Item_Rarity::find($input['id']) : new Item_Rarity);
			$rarity->name  = $input['name'];
			$rarity->color = $input['color'];

			// Attempt to save the object
			$this->save($rarity);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $rarity->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getRaritydelete($rarityId)
	{
		$this->skipView();

		$rarity = Item_Rarity::find($rarityId);
		$rarity->delete();

		return Redirect::to('/game/master/items#rarities');
	}

	public function getItems()
	{
		$classes  = Item::orderByNameAsc()->paginate(20);

		$rarities    = Item_Rarity::orderByNameAsc()->get();
		$rarityArray = $this->arrayToselect($rarities, 'id', 'name', 'Select a rarity');

		// Set up the one page crud
		Crud::setTitle('Items')
				 ->setSortProperty('name')
				 ->setDeleteLink('/game/master/items/itemdelete/')
				 ->setDeleteProperty('id')
				 ->setPaginationFlag(true)
				 ->setResources($classes);

		// Add the display columns
		Crud::addDisplayField('name')
				 ->addDisplayField('rarity_level');

		// Add the form fields
		Crud::addFormField('name', 'text')
				 ->addFormField('item_rarity_id', 'select', $rarityArray)
				 ->addFormField('description', 'textarea');

		Crud::make();
	}

	public function postItems()
	{
		$this->skipView();
		// Set the input data
		$input = e_array(Input::all());

		if ($input != null) {
			// Get the object
			$item                = (isset($input['id']) && $input['id'] != null ? Item::find($input['id']) : new Item);
			$item->name          = $input['name'];
			$item->description   = $input['description'];

			// Attempt to save the object
			$this->save($item);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success')->addData('resource', $item->toArray());
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}

	public function getItemdelete($itemId)
	{
		$this->skipView();

		$item = Item::find($itemId);
		$item->delete();

		return Redirect::to('/game/master/items#items');
	}

}