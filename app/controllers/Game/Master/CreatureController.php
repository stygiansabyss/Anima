<?php

class Game_Master_CreatureController extends Game_Master_CharacterController {

	public $type = 'Creature';

	protected function getObjects($gameId, $characterId)
	{
		$this->gameId = $gameId;
		$this->game   = Game::find($gameId);

		$this->characterId = $characterId;
		$this->character   = Creature::find($characterId);
	}

	public function getCreate($gameId)
	{
		LeftTab::
			addPanel()
				->setTitle('Creature Creation')
				->setBasePath('game/master/creature')
				->addTab('Start', "start/{$gameId}")
			->buildPanel()
		->setGlow(true)
		->make();
	}

	public function getUpdate($gameId, $characterId)
	{
		LeftTab::
			addPanel()
				->setTitle('Creature Update')
				->setBasePath('game/master/creature')
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
			$character            = new Creature;
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

			return $this->redirect('/game/master/creature/update/'. $gameId .'/'. $character->id, 'Creature created.');
		}

		return $this->redirect('/game/master/creature/create/'. $gameId);
	}

	public function getStats($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$stats = Stat::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.stats');
		$this->setViewData('character', $this->character);
		$this->setViewData('stats', $stats);
		$this->setViewData('type', $this->type);
	}
}