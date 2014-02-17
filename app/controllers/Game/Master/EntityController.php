<?php

class Game_Master_EntityController extends BaseController {

	public function postCreate($gameId)
	{
		$input = e_array(Input::all());

		if ($input != null) {
			// Create the entity
			$entity              = new Entity;
			$entity->name        = $input['name'];
			$entity->color       = $input['color'];
			$entity->description = $input['description'];
			$entity->hiddenFlag  = isset($input['hiddenFlag']) ? 1 : 0;
			$entity->activeFlag  = isset($input['activeFlag']) ? 1 : 0;

			$this->checkErrorsSave($entity);

			// Handle the avatar
			if (Input::hasFile('avatar')) {
				CoreImage::addImage(public_path() .'/img/avatars/Entity', Input::file('avatar'), Str::studly($entity->name));
				$imageErrors = CoreImage::getErrors();

				if (count($imageErrors) > 0) {
					$this->addErrors($imageErrors);
				}
			}

			$this->redirect('/game/master/manage/'. $gameId, 'Entity created.');
		}
	}

	public function getEdit($characterId, $gameId)
	{
		$entity = Entity::find($characterId);

		$this->setViewData('entity', $entity);
	}

	public function postEdit($characterId, $gameId)
	{
		$input = e_array(Input::all());

		if ($input != null) {
			// Create the entity
			$entity              = Entity::find($characterId);
			$entity->name        = $input['name'];
			$entity->color       = $input['color'];
			$entity->description = $input['description'];
			// $entity->hiddenFlag  = isset($input['hiddenFlag']) ? 1 : 0;
			$entity->activeFlag  = isset($input['activeFlag']) ? 1 : 0;

			$this->checkErrorsSave($entity);

			// Handle the avatar
			if (Input::hasFile('avatar')) {
				CoreImage::addImage(public_path() .'/img/avatars/Entity/', Input::file('avatar'), Str::studly($entity->name));
				$imageErrors = CoreImage::getErrors();

				if (count($imageErrors) > 0) {
					$this->addErrors($imageErrors);
				}
			}

			$this->redirect('/game/master/manage/'. $gameId, 'Entity updated.');
		}
	}
}