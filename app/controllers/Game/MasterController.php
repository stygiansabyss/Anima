<?php

class Game_MasterController extends BaseController {

	public function getManage($gameId)
	{
		$game        = Game::with('characters')->find($gameId);
		$entities    = Entity::orderBy('activeFlag', 'desc')->orderByNameAsc()->get();
		$recentPosts = array();

		LeftTab::
			addPanel()
				->setTitle('Awaiting Attention')
				->setBasePath('game/master')
				->addTab('Magic Trees', 'magic-trees/'. $gameId, 'magic-trees', array('badge' => $game->unApprovedTrees->count()))
				->addTab('Magic Spells', 'magic-spells/'. $gameId, 'magic-spells', array('badge' => $game->unApprovedSpells->count()))
				->addTab('Character Spell Access', 'character-spells/'. $gameId, 'character-spells', array('badge' => $game->unApprovedCharacterSpells->count()))
				->addTab('Unapproved Characters', 'applications/'. $gameId, 'applications', array('badge' => $game->unApprovedCharacters->count()))
				->addTab('In Progress Characters', 'in-progress/'. $gameId, 'in-progress', array('badge' => $game->inProgressCharacters->count()))
				// ->addTab('Action Posts', 'action-posts/'. $gameId, 'action-posts', array('badge' => $game->actionsAwaitingApproval->count()))
				->buildPanel()
			->addPanel()
				->setTitle('Characters')
				->setBasePath('game/master')
				->addTab('Characters', 'characters/'. $gameId, 'characters', array('badge' => $game->playerCharacters->count()))
				->addTab('Enemies', 'enemies/'. $gameId, 'enemies', array('badge' => $game->enemies->count()))
				->addTab('NPCs', 'npcs/'. $gameId, 'npcs', array('badge' => $game->npcs->count()))
				->addTab('Creatures', 'creatures/'. $gameId, 'creatures', array('badge' => $game->creatures->count()))
				->addTab('Entities', 'entities/'. $gameId, 'entities', array('badge' => $entities->count()))
				->addTab('Inactive', 'inactive/'. $gameId, 'inactive', array('badge' => $game->deadCharacters->count()))
				->buildPanel()
			->setDefaultTab('characters')
			->setGlow(true)
		->make();

		$this->setViewData('game', $game);
		$this->setViewData('entities', $entities);
		$this->setViewData('recentPosts', $recentPosts);
	}

	public function postManage($gameId)
	{
		$this->skipView();

		$input = Input::all();

		if ($input != null) {
			if (isset($input['exp']) && $input['exp'] != null) {
				$character = $input['character_type']::find($input['character_id']);

				$character->addExperience($input['exp'], $this->activeUser->id, $input['reason']);
			}
		}

		$this->redirect(Request::path(), $character->name .' has been granted '. $input['exp'] .' experience points.');
	}

	public function getMagicTrees($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewData('game', $game);
	}

	public function getMagicSpells($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewData('game', $game);
	}

	public function getCharacterSpells($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewData('game', $game);
	}

	public function getApplications($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewData('game', $game);
	}

	public function getInProgress($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewData('game', $game);
	}

	public function getCharacters($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'Characters');
		$this->setViewData('type', 'character');
		$this->setViewData('characters', $game->playerCharacters);
	}

	public function getEnemies($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'Enemies');
		$this->setViewData('type', 'enemy');
		$this->setViewData('characters', $game->enemies);
	}

	public function getNpcs($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'NPCs');
		$this->setViewData('type', 'npc');
		$this->setViewData('characters', $game->npcs);
	}

	public function getCreatures($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'Creatures');
		$this->setViewData('type', 'creature');
		$this->setViewData('characters', $game->creatures);
	}

	public function getEntities($gameId)
	{
		$game        = Game::with('characters')->find($gameId);

		$entities    = Entity::orderBy('activeFlag', 'desc')->orderByNameAsc()->get();

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'Entities');
		$this->setViewData('type', 'entity');
		$this->setViewData('characters', $entities);
	}

	public function getInactive($gameId)
	{
		$game = Game::with('characters')->find($gameId);

		$this->setViewPath('game.master.components.character.list');
		$this->setViewData('game', $game);
		$this->setViewData('title', 'Inactive Characters');
		$this->setViewData('type', 'inactive');
		$this->setViewData('characters', $game->deadCharacters);
	}

	public function getStatus($resourceId, $resourceType, $property, $value)
	{
		$this->skipView();

		$statusId = Status::where('keyName', $property)->first()->id;

		if ($value == 1) {
			$findByDetails = [
				'morph_id'   => $resourceId,
				'morph_type' => $resourceType,
				'status_id'  => $statusId
			];
			$status             = Character_Status::firstOrNew($findByDetails);
			$status->morph_id   = $resourceId;
			$status->morph_type = $resourceType;
			$status->status_id  = $statusId;

			$this->save($status);
		} else {
			$existingStatus = Character_Status::where('morph_id', $resourceId)->where('morph_type', $resourceType)->where('status_id', $statusId)->first();

			if ($existingStatus != null) {
				$existingStatus->delete();
			}
		}

		return $this->redirect('back', $resourceType .' successfully updated.');
	}

	public function getUpdate($resourceId, $property, $value, $resourceType = 'Character')
	{
		$this->skipView();

		$resource              = $resourceType::find($resourceId);
		$resource->{$property} = $value;

		$this->save($resource);

		return $this->redirect('back', $resource->name .' successfully updated.');
	}

	public function getDenySpell($spellId)
	{
		$this->skipView();

		$spell = Magic_Spell::find($spellId);
		$spell->delete();

		return $this->redirect('back', 'Spell has been denied.');
	}

	public function getDenyCharacterSpell($spellId)
	{
		$this->skipView();

		$spell = Character_Spell::find($spellId);
		$spell->delete();

		return $this->redirect('back', 'Spell has been denied.');
	}

	public function getCharacterDelete($type, $id)
	{
		$this->skipView();

		$character = $type::find($id);
		$character->delete();

		$this->redirect('back', $character->name .' deleted');
	}

	public function getCharacterExpHistory($morphType, $morphId)
	{
		$expHistory = Character_Experience_History::where('morph_type', $morphType)->where('morph_id', $morphId)->get();
		$character  = $morphType::find($morphId);

		$this->setViewPath('game.master.components.character.exphistory');
		$this->setViewData('expHistory', $expHistory);
		$this->setViewData('character', $character);
	}

	public function getCharacterStatus($characterId, $type, $gameId)
	{
		$character = $type::find($characterId);

		$statuses          = Status::orderByNameAsc()->get()->toSelectArray();
		$characterStatuses = Character_Status::where('morph_id', $characterId)->where('morph_type', $type)->get()->status_id->toArray();

		$this->setViewPath('game.master.components.character.status');
		$this->setViewData('character', $character);
		$this->setViewData('statuses', $statuses);
		$this->setViewData('characterStatuses', $characterStatuses);
		$this->setViewData('gameId', $gameId);
	}

	public function postCharacterStatus($characterId, $type, $gameId)
	{
		$statuses = Input::get('status');
		$existingStatuses = Character_Status::where('morph_id', $characterId)->where('morph_type', $type)->get();

		$existingStatuses->delete();

		if (count($statuses) > 0) {
			foreach ($statuses as $statusId) {
				$newStatus             = new Character_Status;
				$newStatus->morph_id   = $characterId;
				$newStatus->morph_type = $type;
				$newStatus->status_id  = $statusId;

				$this->save($newStatus);
			}
		}

		return $this->redirect('/game/master/manage/'. $gameId, 'Character statuses updated.');
	}

	public function getConvertToEnemy($gameId, $resourceId, $resourceType)
	{
		$resource = $resourceType::find($resourceId);

		$newEnemy             = new Enemy;
		$newEnemy->id         = $resource->id;
		$newEnemy->name       = $resource->name;
		$newEnemy->color      = $resource->color;
		$newEnemy->parent_id  = $resource->parent_id;
		$newEnemy->oldId      = $resource->oldId;
		$newEnemy->created_at = $resource->created_at;
		$newEnemy->updated_at = $resource->updated_at;
		$newEnemy->deleted_at = $resource->deleted_at;
		$newEnemy->noExpFlag  = 0;

		$this->save($newEnemy);

		Character_Status::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Stat::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Skill::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Attribute::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Attribute_Secondary::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Appearance::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Spell::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});

		Character_Trait::where('morph_id', $resource->id)->get()->each(function($object) {
			$object->morph_type = 'Enemy';
			$object->save();
		});
	}

	public function getConvertToCharacter($gameId, $resourceId, $resourceType)
	{
		
	}

	public function getConvertToCreature($gameId, $resourceId, $resourceType)
	{

	}

}