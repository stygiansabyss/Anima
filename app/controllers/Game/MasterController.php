<?php

class Game_MasterController extends BaseController {

	public function getManage($gameId)
	{
		$game        = Game::with('characters')->find($gameId);
		$entities    = Entity::orderBy('activeFlag', 'desc')->orderByNameAsc()->get();
		$recentPosts = array();

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

}