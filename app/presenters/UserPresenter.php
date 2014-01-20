<?php

class UserPresenter extends Core\UserPresenter {

	public function getGameCharacters($gameId)
	{
		$characters = $this->resource->characters;

		$characters = $characters->filter(function ($character) use ($gameId) {
			if ($character->games->where('game_id', $gameId)->count() > 0) return true;
		});

		return $characters;
	}
}