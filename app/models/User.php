<?php

class User extends Core\User {
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public function __construct()
	{
		parent::__construct();

		self::$relationsData = array_merge(parent::$relationsData, array(
			'games'      => array('hasMany', 'Game_Storyteller',	'foreignKey' => 'user_id'),
			'characters' => array('hasMany', 'Character',			'foreignKey' => 'user_id'),
			'enemies'    => array('hasMany', 'Enemy',				'foreignKey' => 'user_id'),
			'rolls'      => array('hasMany', 'Character_Roll',		'foreignKey' => 'user_id', 'orderBy' => array('roll', 'desc')),
		));
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
	public function isStoryTeller($gameId)
	{
		return in_array($gameId, $this->games->game_id->toArray());
	}

	public function characterInProgress()
	{
		$characters = $this->characters;

		$characters->filter(function ($character) {
			return $character->checkStatus(['IN_PROGRESS', 'AWAITING_APPROVAL']);
		});

		return $character->count() > 0;
	}
}