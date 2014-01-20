<?php

class Chat_Room extends Core\Chat_Room
{
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public function __construct()
	{
		parent::__construct();

		self::$relationsData = array_merge(parent::$relationsData, array(
			'game' => array('belongsTo', 'Game', 'foreignKey' => 'game_id'),
		));
	}
}