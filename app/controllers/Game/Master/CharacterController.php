<?php

class Game_Master_CharacterController extends BaseController {

	public $game;
	public $gameId;

	public $character;
	public $characterId;

	public $type = 'Character';

	protected function getObjects($gameId, $characterId)
	{
		$this->gameId = $gameId;
		$this->game   = Game::find($gameId);

		$this->characterId = $characterId;
		$this->character   = Character::find($characterId);
	}

	public function getCreate($gameId)
	{
		LeftTab::
			addPanel()
				->setTitle('Character Creation')
				->setBasePath('game/master/character')
				->addTab('Start', "start/{$gameId}")
			->buildPanel()
		->setGlow(true)
		->make();
	}

	public function getUpdate($gameId, $characterId)
	{
		LeftTab::
			addPanel()
				->setTitle('Character Update')
				->setBasePath('game/master/character')
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

	public function getStart($gameId)
	{
		$users = User::orderByNameAsc()->get()->filter(function ($user) {
			if ($user->can('PLAY_GAMES')) return true;
		})->toSelectArray('Select a user', 'id', 'username');

		$characters = Game::find($gameId)->characters->filter(function ($character) {
			if ($character->morph_type == $this->type) return true;
		})->morph->toSelectArray('Select a parent');

		$this->setViewPath('game.master.character.start');
		$this->setViewData('users', $users);
		$this->setViewData('characters', $characters);
		$this->setViewData('type', $this->type);
	}

	public function postStart($gameId)
	{
		$input = Input::all();

		if ($input != null) {
			$character            = new Character;
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

			return $this->redirect('/game/master/character/update/'. $gameId .'/'. $character->id, 'Character created.');
		}

		return $this->redirect('/game/master/character/create/'. $gameId);
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

		$this->setViewPath('game.master.character.basics');
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

	public function getStatuses($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$statuses = Status::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.statuses');
		$this->setViewData('character', $this->character);
		$this->setViewData('statuses', $statuses);
		$this->setViewData('type', $this->type);
	}

	public function postStatuses($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		Character_Status::where('morph_id', $characterId)->where('morph_type', $this->type)->delete();

		$statusKeys = array_keys(Input::get('status'));

		foreach ($statusKeys as $statusId) {
			$characterStatus             = new Character_Status;
			$characterStatus->morph_id   = $characterId;
			$characterStatus->morph_type = $this->type;
			$characterStatus->status_id  = $statusId;

			$this->save($characterStatus);
		}

		// Handle errors
		if ($this->errorCount() > 0) {
			Ajax::addErrors($this->getErrors());
		} else {
			Ajax::setStatus('success');
		}

		// Send the response
		return Ajax::sendResponse();
	}

	public function getDetails($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$magicTypes = Magic_Type::orderByNameAsc()->get()->toSelectArray('None');

		$details = new stdClass();
		if (!is_null($this->character->details)) {
			$details = $this->character->details;
		} else {
			$details->level         = 3;
			$details->experience    = 0;
			$details->hitPoints     = 0;
			$details->magicPoints   = 0;
			$details->magic_type_id = 0;
			$details->gold          = 0;
			$details->silver        = 0;
			$details->copper        = 0;
			$details->armorWeapons  = null;
			$details->generalItems  = null;
		}

		$this->setViewPath('game.master.character.details');
		$this->setViewData('character', $this->character);
		$this->setViewData('magicTypes', $magicTypes);
		$this->setViewData('details', $details);
		$this->setViewData('type', $this->type);
	}

	public function postDetails($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			$details                  = Character_Detail::firstOrNew(array('morph_id' => $characterId, 'morph_type' => $this->type));
			$details->morph_id        = $characterId;
			$details->morph_type      = $this->type;
			$details->level           = $input['level'];
			$details->experience      = $input['experience'];
			$details->magic_type_id   = $input['magic_type_id'] != '0' ? $input['magic_type_id'] : null;
			$details->hitPoints       = $input['hitPoints'];
			$details->tempHitPoints   = $input['hitPoints'];
			$details->magicPoints     = $input['magicPoints'];
			$details->tempMagicPoints = $input['magicPoints'];
			$details->gold            = $input['gold'];
			$details->silver          = $input['silver'];
			$details->copper          = $input['copper'];
			$details->armorWeapons    = $input['armorWeapons'];
			$details->generalItems    = $input['generalItems'];

			$this->save($details);

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

	public function getAppearances($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$appearances = Appearance::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.appearances');
		$this->setViewData('character', $this->character);
		$this->setViewData('appearances', $appearances);
		$this->setViewData('type', $this->type);
	}

	public function postAppearances($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['appearances'] as $appearanceId => $value) {
				$findByDetails = [
					'morph_id'      => $characterId,
					'morph_type'    => $this->type,
					'appearance_id' => $appearanceId
				];
				$appearance                = Character_Appearance::firstOrNew($findByDetails);
				$appearance->morph_id      = $characterId;
				$appearance->morph_type    = $this->type;
				$appearance->appearance_id = $appearanceId;
				$appearance->value        = $value;

				$this->save($appearance);
			}

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

	public function getStats($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$stats = Stat::where('creatureFlag', 0)->orderByNameAsc()->get();

		$this->setViewPath('game.master.character.stats');
		$this->setViewData('character', $this->character);
		$this->setViewData('stats', $stats);
		$this->setViewData('type', $this->type);
	}

	public function postStats($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['stats'] as $statId => $value) {
				$findByDetails = [
					'morph_id'   => $characterId,
					'morph_type' => $this->type,
					'stat_id'    => $statId
				];
				$stat             = Character_Stat::firstOrNew($findByDetails);
				$stat->morph_id   = $characterId;
				$stat->morph_type = $this->type;
				$stat->stat_id    = $statId;
				$stat->value      = $value;

				$this->save($stat);
			}

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

	public function getClass($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$classes = Game_Class::orderByNameAsc()->get()->toSelectArray('Select a class');

		$this->setViewPath('game.master.character.class');
		$this->setViewData('character', $this->character);
		$this->setViewData('classes', $classes);
		$this->setViewData('type', $this->type);
	}

	public function postClass($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			$findByDetails = [
				'morph_id'     => $characterId,
				'morph_type'   => $this->type,
				'class_id'     => $input['class_id']
			];
			$class             = Character_Class::firstOrNew($findByDetails);
			$class->morph_id   = $characterId;
			$class->morph_type = $this->type;
			$class->class_id   = $input['class_id'];

			$this->save($class);

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

	public function getAttributes($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$attributes = Attribute::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.attributes');
		$this->setViewData('character', $this->character);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('type', $this->type);
	}

	public function postAttributes($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['attributes'] as $attributeId => $value) {
				$findByDetails = [
					'morph_id'     => $characterId,
					'morph_type'   => $this->type,
					'attribute_id' => $attributeId
				];
				$attribute               = Character_Attribute::firstOrNew($findByDetails);
				$attribute->morph_id     = $characterId;
				$attribute->morph_type   = $this->type;
				$attribute->attribute_id = $attributeId;
				$attribute->value        = $value;

				$this->save($attribute);
			}

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

	public function getSecondaryAttributes($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$attributes = Attribute_Secondary::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.secondaryattributes');
		$this->setViewData('character', $this->character);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('type', $this->type);
	}

	public function postSecondaryAttributes($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['attributes'] as $attributeId => $value) {
				$findByDetails = [
					'morph_id'     => $characterId,
					'morph_type'   => $this->type,
					'attribute_id' => $attributeId
				];
				$attribute               = Character_Attribute_Secondary::firstOrNew($findByDetails);
				$attribute->morph_id     = $characterId;
				$attribute->morph_type   = $this->type;
				$attribute->attribute_id = $attributeId;
				$attribute->value        = $value;

				$this->save($attribute);
			}

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

	public function getSkills($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$skills = Skill::orderByNameAsc()->get();

		$this->setViewPath('game.master.character.skills');
		$this->setViewData('character', $this->character);
		$this->setViewData('skills', $skills);
		$this->setViewData('type', $this->type);
	}

	public function postSkills($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['skills'] as $skillId => $value) {
				$findByDetails = [
					'morph_id'   => $characterId,
					'morph_type' => $this->type,
					'skill_id'   => $skillId
				];
				$skill             = Character_Skill::firstOrNew($findByDetails);
				$skill->morph_id   = $characterId;
				$skill->morph_type = $this->type;
				$skill->skill_id   = $skillId;
				$skill->value      = $value;

				$this->save($skill);
			}

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

	public function getAdvantages($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$advantages = Game_Trait::advantage()->orderByNameAsc()->get();

		$this->setViewPath('game.master.character.advantages');
		$this->setViewData('character', $this->character);
		$this->setViewData('advantages', $advantages);
		$this->setViewData('type', $this->type);
	}

	public function postAdvantages($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['advantages'] as $traitId => $value) {
				$findByDetails = [
					'morph_id'   => $characterId,
					'morph_type' => $this->type,
					'trait_id'   => $traitId
				];
				$trait             = Character_Trait::firstOrNew($findByDetails);
				$trait->morph_id   = $characterId;
				$trait->morph_type = $this->type;
				$trait->trait_id   = $traitId;
				$trait->value      = $value;

				$this->save($skill);
			}

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

	public function getDisadvantages($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$disadvantages = Game_Trait::disadvantage()->orderByNameAsc()->get();

		$this->setViewPath('game.master.character.disadvantages');
		$this->setViewData('character', $this->character);
		$this->setViewData('disadvantages', $disadvantages);
		$this->setViewData('type', $this->type);
	}

	public function postDisadvantages($gameId, $characterId)
	{
		$this->getObjects($gameId, $characterId);

		$input = e_array(Input::all());

		if ($input != null) {
			foreach ($input['disadvantages'] as $traitId => $value) {
				$findByDetails = [
					'morph_id'   => $characterId,
					'morph_type' => $this->type,
					'trait_id'   => $traitId
				];
				$trait             = Character_Trait::firstOrNew($findByDetails);
				$trait->morph_id   = $characterId;
				$trait->morph_type = $this->type;
				$trait->trait_id   = $traitId;
				$trait->value      = $value;

				$this->save($skill);
			}

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