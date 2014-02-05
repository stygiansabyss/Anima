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
		$this->skipView();

		$input = e_array(Input::all());

		if ($input != null) {
			$character = $input['morph_type']::find($input['morph_id']);

			$type = $input['type'];

			$dmge = $input['dmg'];
			$used = $input['use'];

			$fullHp = $character->details->hitPoints;
			$tempHp = $character->details->tempHitPoints;
			$fullMp = $character->details->magicPoints;
			$tempMp = $character->details->tempMagicPoints;

			if ($dmge != null || $type == 'resetHit') {
				$character->details->tempHitPoints = $this->handleCalculation($type, $tempHp, $fullHp, $dmge);
			}

			if ($used != null || $type == 'resetMagic') {
				$character->details->tempMagicPoints = $this->handleCalculation($type, $tempMp, $fullMp, $used);
			}

			$character->details->save();
		}
	}

	protected function handleCalculation($type, $originalValue, $fullValue, $amount)
	{
		switch ($type) {
			case 'sub':
				return $originalValue - $amount;
			break;
			case 'add':
				return $originalValue + $amount;
			break;
			case 'resetMagic':
			case 'resetHit':
				return $fullValue;
			break;
		}
	}
}