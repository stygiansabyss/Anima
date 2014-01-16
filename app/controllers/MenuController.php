<?php

class MenuController extends Core_BaseController
{

	public function getMenu()
	{
		Menu::addMenuItem('Home', '/')
			->addMenuItem('Memberlist', 'memberlist')
			->addMenuItem('Help', 'help');

		if (Auth::check()) {
			// Forum access
			if ($this->hasPermission('FORUM_ACCESS')) {
				$postsCount = $this->activeUser->unreadPostCount();
				$forumTitle = ($postsCount > 0 ? 'Forums ('. $postsCount .')' : 'Forums');

				Menu::addMenuItem($forumTitle, 'forum', null, 1)
					->addMenuChild($forumTitle, 'Search', 'forum/search');

				// Forum Moderation
				if ($this->hasPermission('FORUM_MOD')) {
					Menu::addMenuChild($forumTitle, 'Moderation Panel', 'forum/moderation/dashboard');
				}

				// Forum Administration
				if ($this->hasPermission('FORUM_ADMIN')) {
					Menu::addMenuChild($forumTitle, 'Admin Panel', 'forum/admin/dashboard')
						->addChildChild('Forums', 'Admin Panel', 'Add Category', 'forum/category/add')
						->addChildChild('Forums', 'Admin Panel', 'Add Board', 'forum/board/add');
				}
			}

			// Chats
			Menu::addMenuItem('Chats', 'chat', null, 2);

			// GM Areas
			if ($this->hasPermission('GAME_MASTER')) {
				Menu::addMenuItem('Game Master', 'game/master', null, 3)
					->addMenuChild('Game Master', 'Manage', null)
					->addMenuChild('Game Master', 'Rules', null)
					->addChildChild('Game Master', 'Rules', 'Core', 'game/master/rules/core')
					->addChildChild('Game Master', 'Rules', 'Items', 'game/master/items')
					->addChildChild('Game Master', 'Rules', 'Combat Modules', 'game/master/rules/modules')
					->addChildChild('Game Master', 'Rules', 'Creature Abilities', 'game/master/rules/abilities')
					->addChildChild('Game Master', 'Rules', 'Ki', 'game/master/rules/ki')
					->addChildChild('Game Master', 'Rules', 'Magic', 'game/master/rules/magic')
					->addChildChild('Game Master', 'Rules', 'Psychic', 'game/master/rules/psychic')
					->addChildChild('Game Master', 'Rules', 'Summoning', 'game/master/rules/summoning');

				$games = Game::orderByNameAsc()->get();

				foreach ($games as $game) {
					if ($this->activeUser->isStoryTeller($game->id)) {
						Menu::addChildChild('Game Master', 'Manage', $game->name, 'game/master/manage/'. $game->id);
					}
				}
			}

			if ($this->hasPermission('CREATE_GAMES')) {
				Menu::addMenuChild('Game Master', 'Manage Games', 'game/master/games');
			}

			// Manage Menu
			if ($this->hasPermission('DEVELOPER')) {
				Menu::addMenuItem('Management', null, null, null, 'right')
					->addMenuChild('Management', 'Dev Panel', 'admin');

				// Github Links
				if ($this->activeUser->githubToken != null) {
					Menu::addMenuChild('Management', 'Github Issues', 'github')
						->addMenuChild('Management', 'My Github Issues', 'github/user');
				}
			}

			// User Menu
			Menu::addMenuItem($this->activeUser->username .' ('. $this->activeUser->unreadMessageCount .')', 'user/view/'. $this->activeUser->id, null, null, 'right')
				->addMenuChild($this->activeUser->username .' ('. $this->activeUser->unreadMessageCount .')', 'My Messages... ('. $this->activeUser->unreadMessageCount .')', 'messages')
				->addMenuChild($this->activeUser->username .' ('. $this->activeUser->unreadMessageCount .')', 'Characters', 'user/characters')
				->addMenuChild($this->activeUser->username .' ('. $this->activeUser->unreadMessageCount .')', 'Edit Profile', 'user/account')
				->addMenuChild($this->activeUser->username .' ('. $this->activeUser->unreadMessageCount .')', 'Logout', 'logout');
		} else {
			Menu::addMenuItem('Login', 'login', null, null, 'right');
			Menu::addMenuItem('Register', 'register', null, null, 'right');
			Menu::addMenuItem('Forgot Password', 'forgotpassword', null, null, 'right');
		}
	}

	public function setAreaDetails($area)
	{
		$location = (Request::segment(2) != null ? ': '. ucwords(Request::segment(2)) : '');

		if ($area != null) {
			$this->pageTitle = ucwords($area).$location;
		} else {
			$this->pageTitle = Config::get('app.siteName'). (Request::segment(1) != null ? ': '.ucwords(Request::segment(1)) : '');
		}
	}
}