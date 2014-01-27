<?php

class GameController extends BaseController {

	public function getStBoard($gameId)
	{
		if (!$this->activeUser->isStoryTeller($gameId)) {
			throw new Exception('You must be a story-teller to access this area.');
		}

		$this->setViewData('gameId', $gameId);
	}

	public function getBoard($gameId)
	{
		$game = Game::find($gameId);

		$characters = $game->playerCharacters;

		$this->setViewData('characters', $characters);
	}

	public function getBoardDisplay($gameId)
	{
		$game = Game::find($gameId);

		$characters = $game->playerCharacters;
		$npcs       = $game->npcs;
		$creatures  = $game->creatures;
		$inactive   = $game->deadCharacters;

		$this->setViewData('characters', $characters);
		$this->setViewData('npcs', $npcs);
		$this->setViewData('creatures', $creatures);
		$this->setViewData('inactive', $inactive);
	}

	public function postBoardDisplay($gameId)
	{
		ppd(Input::all());
	}

	public function postUpdateCharacter()
	{
		ppd(Input::all());
	}
}