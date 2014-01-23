<?php

class Chat extends Core\Chat
{
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public function __construct()
	{
		parent::__construct();

		self::$relationsData = array_merge(parent::$relationsData, array(
			'morph' => array('morphTo'),
		));
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/

	public function sendToNode ($messageObject) 
	{

		$newMessage = ParseChat::parse($messageObject);

		$node = new SocketIOClient(Config::get('app.url') .':1337', 'socket.io', 1, false, true, true);
		$node->init();
		$node->send(
			SocketIOClient::TYPE_EVENT,
			null,
			null,
			json_encode(array('name' => 'message', 'args' => $newMessage))
			);
		$node->close();
	}
}