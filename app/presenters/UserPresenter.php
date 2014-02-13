<?php

class UserPresenter extends Syntax\Core\UserPresenter {

	public function getGameCharacters($gameId)
	{
		$characters = $this->resource->characters;

		$characters = $characters->filter(function ($character) use ($gameId) {
			if ($character->games->where('game_id', $gameId)->count() > 0) return true;
		});

		return $characters;
	}

	public function getEntities()
	{
		if ($this->resource->checkPermission('POST_AS_ENTITY')) {
			return Entity::orderByNameAsc()->get();
		}

		return array();
	}

	public function postAs() {
		$postAs = array('User::'. $this->resource->id => $this->resource->username);

		foreach ($this->resource->characters as $character) {
			if (!$character->checkStatus(array('ACTIVE', 'APPROVED'), true)) continue;
			$postAs[getRootClass($character) .'::'. $character->id] = $character->name;
		}
		foreach ($this->resource->enemies as $character) {
			if (!$character->checkStatus(array('ACTIVE', 'APPROVED'), true)) continue;
			$postAs[getRootClass($character) .'::'. $character->id] = $character->name;
		}
		foreach ($this->resource->creatures as $character) {
			if (!$character->checkStatus(array('ACTIVE', 'APPROVED'), true)) continue;
			$postAs[getRootClass($character) .'::'. $character->id] = $character->name;
		}
		if ($this->resource->checkPermission('POST_AS_ENTITY')) {
			$entities = Entity::orderByNameAsc()->get();

			foreach ($entities as $entity) {
				$postAs['Entity::'. $entity->id] = $entity->name;
			}
		}

		return $postAs;
	}
}