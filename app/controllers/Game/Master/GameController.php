<?php

class Game_Master_GameController extends BaseController {

	public function getIndex()
	{
		$games = Game::orderByNameAsc()->get();

		// ppd($games->storyTellers);

		$this->setViewData('games', $games);
	}

	public function getAdd()
	{
		$users = User::orderByNameAsc()->get();

		$users = $users->filter(function ($user) {
			if ($user->can('RUN_GAMES')) {
				return true;
			}
		});

		$userArray = $this->arrayToSelect($users, 'id', 'username', false);

		$this->setViewData('userArray', $userArray);
	}

	public function postAdd()
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			$game              = new Game;
			$game->name        = $input['name'];
			$game->keyName     = $input['keyName'];
			$game->description = $input['description'];
			$game->activeFlag  = isset($input['activeFlag']) ? 1 : 0;

			$this->checkErrorsSave($game);

			$game->setStoryTellers($input['users']);
		}

		$this->redirect('/game/master/games', 'New game created.');
	}

	public function getEdit($gameId)
	{
		$game = Game::find($gameId);

		$users = User::orderByNameAsc()->get();

		$users = $users->filter(function ($user) {
			if ($user->can('RUN_GAMES')) {
				return true;
			}
		});

		$userArray = $this->arrayToSelect($users, 'id', 'username', false);

		$stArray = Game_Storyteller::where('game_id', $gameId)->get()->user_id->toArray();

		$this->setViewData('game', $game);
		$this->setViewData('userArray', $userArray);
		$this->setViewData('stArray', $stArray);
	}

	public function postEdit($gameId)
	{
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			$game              = Game::find($gameId);
			$game->name        = $input['name'];
			$game->keyName     = $input['keyName'];
			$game->description = $input['description'];
			$game->activeFlag  = isset($input['activeFlag']) ? 1 : 0;

			$this->checkErrorsSave($game);

			$game->setStoryTellers($input['users']);
		}

		$this->redirect('/game/master/games', 'Game updated.');
	}

	public function getDelete($gameId)
	{
		$game = Game::find($gameId);
		$game->delete();

		$this->redirect('/game/master/games', $game->name .' deleted.');
	}

}