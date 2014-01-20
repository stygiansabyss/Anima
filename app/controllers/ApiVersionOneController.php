<?php

class ApiVersionOneController extends Core_ApiVersionOneController {

	public function getChatRoomLog($chatRoomId, $backLog = 30)
	{
		$this->skipView();

		$chatRoomId = e($chatRoomId);

		$messageOutput = array();

		$chatMessages = Chat::where('chat_room_id', '=', $chatRoomId)
			->orderBy('created_at','desc')
			->take($backLog)
			->get();

		foreach ($chatMessages as $messageObject) {
			$messageOutput[] = ParseChat::parse($messageObject, true);
		}

		$messageOutput = array_reverse($messageOutput);

		return json_encode($messageOutput);
	}
}