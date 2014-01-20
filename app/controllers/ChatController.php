<?php

class ChatController extends Core_ChatController {

	public $type = 'chat';

	public function getRoom($chatRoomId = null, $message = null)
	{
		parent::getRoom($chatRoomId, $message);

		$skills      = Skill::orderByNameAsc()->take(10)->get()->name->toArray();
		$spells      = Magic_Spell::orderByNameAsc()->take(10)->get()->name->toArray();
		$attributes  = Attribute::orderByNameAsc()->take(10)->get()->name->toArray();
		$secondaries = Attribute_Secondary::orderByNameAsc()->take(10)->get()->name->toArray();

		$this->setViewData('skills', $skills);
		$this->setViewData('spells', $spells);
		$this->setViewData('attributes', $attributes);
		$this->setViewData('secondaries', $secondaries);
	}

	public function getAdd()
	{
		$games = Game::orderByNameAsc()->get();
		$games = $this->arrayToSelect($games, 'id', 'name', 'Select a game');

		$this->setViewData('games', $games);
	}

	public function postAdd()
	{
		// Handle the form input
		$input = e_array(Input::all());

		if ($input != null) {
			$room             = new Chat_Room;
			$room->user_id    = $this->activeUser->id;
			$room->name       = $input['name'];
			$room->game_id    = $input['game_id'];
			$room->activeFlag = (isset($input['activeFlag']) ? 1 : 0);

			$this->checkErrorsSave($room);

			return $this->redirect('chat', $room->name .' has been created.');
		}
	}

	public function getEdit($chatRoomId)
	{
		$chatRoom = Chat_Room::find($chatRoomId);

		$games = Game::orderByNameAsc()->get();
		$games = $this->arrayToSelect($games, 'id', 'name', 'Select a game');

		$this->setViewData('chatRoom', $chatRoom);
		$this->setViewData('games', $games);
	}

	public function postEdit($chatRoomId)
	{
		// Handle the form input
		$input = e_array(Input::all());

		if ($input != null) {
			$room             = Chat_Room::find($chatRoomId);
			$room->user_id    = $this->activeUser->id;
			$room->name       = $input['name'];
			$room->game_id    = $input['game_id'];
			$room->activeFlag = (isset($input['activeFlag']) ? 1 : 0);

			$this->checkErrorsSave($room);

			return $this->redirect('chat', $room->name .' has been updated.');
		}
	}

	public function postFullChat($chatRoomId)
	{
		$postId  = Input::get('post_id');
		$boardId = Input::get('board_id');
		$title   = Input::get('title');

		if ($postId == '0') $postId = null;
		if ($boardId == '0') $boardId = null;

		// Run through some error checking to make sure everything is in order
		if ($postId != null && !is_null($boardId)) {
			return $this->redirect('back', 'You have set a post AND a board.  Please set one or the other.');
		}
		if (!is_null($boardId) && $title == null) {
			return $this->redirect('back', 'To create a new post you must specify a title.');
		}
		if ($postId != null) {
			$post = Forum_Post::find($postId);

			if ($post == null) {
				return $this->redirect('back', 'No post found with id '. $postId);
			}
		}
		if (!is_null($boardId)) {
			$board = Forum_Board::find($boardId);

			if ($board == null) {
				return $this->redirect('back', 'No board found with id '. $boardId);
			}
		}

		// Get the requested chats
		$chats = Chat::where('chat_room_id', $chatRoomId)
			->orderBy('created_at', 'asc')
			->skip(Input::get('start') - 1)
			->take(Input::get('end'));

		if (Input::has('characterOnly')) {
			$chats->whereNotNull('morph_id');
		}

		$chats = $chats->get();

		if ($chats->count() == 0) {
			return $this->redirect('back', 'Due to your selections, no chats remained to be moved.');
		}

		if ($postId != null) {
			$reply                      = new Forum_Reply;
			$reply->forum_post_id       = $postId;
			$reply->forum_reply_type_id = Forum_Reply::TYPE_STANDARD;
			$reply->user_id             = $this->activeUser->id;
			$reply->name                = 'Re:'. $post->name;
			$reply->keyName             = Str::studly($reply->name);
			$reply->content             = $this->convertChatsToPost($chats);

			$this->save($reply);

			return $this->redirect('back', 'Chat added as a reply to '. $post->name);
		}

		if (!is_null($boardId)) {
			$post                     = new Forum_Post;
			$post->forum_board_id     = $boardId;
			$post->forum_post_type_id = Forum_Post::TYPE_STANDARD;
			$post->user_id            = $this->activeUser->id;
			$post->morph_id           = null;
			$post->morph_type         = null;
			$post->name               = $title;
			$post->keyName            = Str::studly($title);
			$post->content            = $this->convertChatsToPost($chats);

			$this->save($post);

			$post->modified_at = $post->created_at;
			$this->save($post);

			return $this->redirect('back', 'Chat added as a new post in '. $board->name);
		}
	}

	protected function convertChatsToPost($chats)
	{
		$content = array();

		foreach ($chats as $chat) {
			$newChat = '';

			if (!Input::has('noTimestamps')) {
				$newChat .= '[spanClass=text-muted][small]('. $chat->created_at .')[/small][/spanClass] ';
			}

			if (!is_null($chat->morph_id)) {
				$newChat .= '[b][url=/character/sheet/'. $chat->morph_id.']'. $chat->morph->name .'[/url][/b]';
			} else {
				if (!is_null($chat->room->game_id)) {
					$newChat .= '[b][spanClass=text-muted][small](OOC)[/small][/spanClass] [url=/user/view/'. $chat->user_id.']'. $chat->user->username .'[/url][/b]';
				} else {
					$newChat .= '[b][url=/user/view/'. $chat->user_id.']'. $chat->user->username .'[/url][/b]';
				}
			}

			$newChat .= ': '. $chat->message ."\n";
			$content[] = $newChat;
		}

		return implode($content);
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
			$message            = ParseChat::parseForCreate($message, $input['morph_id'], $input['morph_type']);

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
