<?php

class ChatController extends Core_ChatController {

	public $type = 'chat';

	public function postAdd()
	{
		// Handle the form input
		$input = e_array(Input::all());

		if ($input != null) {
			$room                   = new Chat_Room;
			$room->user_id          = $this->activeUser->id;
			$room->name             = $input['name'];
			$room->activeFlag       = (isset($input['activeFlag']) ? 1 : 0);

			$this->checkErrorsSave($room);

			return $this->redirect('chat', $room->name .' has been created.');
		}
	}

	public function postAddmessage()
	{
		$this->skipView();

		// Handle the form input
		$input = Input::all();

		if ($input != null) {
			$message            = e($input['message']);
			$message            = preg_replace_callback('/\/rollGm/', 'self::rollGm', $message);
			$message            = preg_replace_callback('/\/roll/', 'self::roll', $message);

			$chat               = new Chat;
			$chat->user_id      = $this->activeUser->id;
			$chat->chat_room_id = $input['chat_room_id'];
			$chat->message      = $message;
			$chat->morph_id     = $input['morph_id'] != null ? $input['morph_id'] : null;
			$chat->morph_type   = $input['morph_type'] != null ? $input['morph_type'] : null;
			$this->save($chat);
		}
	}

    public function roll()
    {
        $roll = rand(1,100);
        $overallRoll = $roll;
        $class = 'text-success';
        while ($roll >= 90) {
            $roll = rand(1,100);
            $overallRoll = $overallRoll + $roll;
        	$class = 'text-warning';
        }

        if ($overallRoll == 9999) {
            $overallRoll = 10000;
        }

        return HTML::image('img/dice_white.png', null, array('style' => 'width: 14px;')) .'<span class="'. $class .'">'. $overallRoll .'</span>';
    }

    public function rollGm()
    {
    	$game = Chat_Room::find(Input::get('chat_room_id'))->game;
    	if (is_null($game) || !$game->isStoryteller($this->activeUser->id)) {
    		return $this->roll() .'Gm';
    	}
        $roll = rand(1,100);
        $overallRoll = $roll;
    	$class = 'text-success';
        while ($roll <= 80) {
            $roll = rand(1,100);
            $overallRoll = $overallRoll + $roll;
        	$class = 'text-warning';
        }

        if ($overallRoll == 9999) {
            $overallRoll = 10000;
        }

        return HTML::image('img/dice_white.png', null, array('style' => 'width: 14px;')) .'<span class="'. $class .'">'. $overallRoll .'</span>';
    }
}
