<?php

class Game_Master_EnemyController extends Game_Master_CharacterController {

	public $type = 'Enemy';

	protected function getObjects($gameId, $characterId)
	{
		$this->gameId = $gameId;
		$this->game   = Game::find($gameId);

		$this->characterId = $characterId;
		$this->character   = Enemy::find($characterId);
	}

	public function getCreate($gameId)
	{
		LeftTab::
			addPanel()
				->setTitle('Enemy Creation')
				->setBasePath('game/master/enemy')
				->addTab('Start', "start/{$gameId}")
			->buildPanel()
		->setGlow(true)
		->make();
	}

	public function getUpdate($gameId, $characterId)
	{
		LeftTab::
			addPanel()
				->setTitle('Enemy Update')
				->setBasePath('game/master/enemy')
				->addTab('Basics', "basics/{$gameId}/{$characterId}")
				->addTab('Statuses', "statuses/{$gameId}/{$characterId}")
				->addTab('Details', "details/{$gameId}/{$characterId}")
				->addTab('Appearances', "appearances/{$gameId}/{$characterId}")
				->addTab('Stats', "stats/{$gameId}/{$characterId}")
				->addTab('Class', "class/{$gameId}/{$characterId}")
				->addTab('Attributes', "attributes/{$gameId}/{$characterId}")
				->addTab('Secondary Attributes', "secondary-attributes/{$gameId}/{$characterId}")
				->addTab('Skills', "skills/{$gameId}/{$characterId}")
				->addTab('Advantages', "advantages/{$gameId}/{$characterId}")
				->addTab('Disadvantages', "disadvantages/{$gameId}/{$characterId}")
			->buildPanel()
		->setGlow(true)
		->make();
	}

	public function postStart($gameId)
	{
		$input = Input::all();

		if ($input != null) {
			$character            = new Enemy;
			$character->name      = $input['name'];
			$character->user_id   = $input['user_id'] != '0' ? $input['user_id'] : null;
			$character->parent_id = $input['parent_id'] != '0' ? $input['parent_id'] : null;

			$this->checkErrorsSave($character);

			$characterGame             = new Game_Character;
			$characterGame->game_id    = $gameId;
			$characterGame->morph_id   = $character->id;
			$characterGame->morph_type = $this->type;

			$this->save($characterGame);

			$characterStatus             = new Character_Status;
			$characterStatus->morph_id   = $character->id;
			$characterStatus->morph_type = $this->type;
			$characterStatus->status_id  = Status::where('keyName', 'IN_PROGRESS')->first()->id;

			$this->save($characterStatus);

			return $this->redirect('/game/master/enemy/update/'. $gameId .'/'. $character->id, 'Enemy created.');
		}

		return $this->redirect('/game/master/enemy/create/'. $gameId);
	}

	public function getBasics($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$users = User::orderByNameAsc()->get()->filter(function ($user) {
			if ($user->can('PLAY_GAMES')) return true;
		})->toSelectArray('Select a user', 'id', 'username');

		$characters = Game::find($gameId)->characters->filter(function ($character) use ($characterId) {
			if ($character->morph_id != $characterId && $character->morph_type == $this->type) return true;
		})->morph->toSelectArray('Select a parent');

		$this->setViewPath('game.master.enemy.basics');
		$this->setViewData('character', $this->character);
		$this->setViewData('users', $users);
		$this->setViewData('characters', $characters);
		$this->setViewData('type', $this->type);
	}

	public function postBasics($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			$this->character->name      = $input['name'];
			$this->character->user_id   = $input['user_id'] != '0' ? $input['user_id'] : null;
			$this->character->parent_id = $input['parent_id'] != '0' ? $input['parent_id'] : null;
			$this->character->noExpFlag = Input::has('noExpFlag') ? 1 : 0;
			$this->character->color     = $input['color'];

			$this->checkErrorsSave($this->character);

			// Handle errors
			if ($this->errorCount() > 0) {
				Ajax::addErrors($this->getErrors());
			} else {
				Ajax::setStatus('success');
			}

			// Send the response
			return Ajax::sendResponse();
		}
	}
}