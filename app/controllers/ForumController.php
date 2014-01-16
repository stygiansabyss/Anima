<?php

class ForumController extends Core_ForumController {

	public function getSearch()
	{
		$typesArray = [
			'all'         => 'All types',
			'Forum_Post'  => 'Post',
			'Forum_Reply' => 'Reply'
		];

		$users = User::orderByNameAsc()->get();
		$users = $this->arrayToSelect($users, 'id', 'username', 'Select a user');

		$characters = Character::orderByNameAsc()->get();
		$enemies    = Enemy::orderByNameAsc()->get();
		$entities   = Entity::orderByNameAsc()->get();
		$creatures  = Creature::orderByNameAsc()->get();

		$characters->merge($enemies)->merge($entities)->merge($creatures);
		$characters = $this->arrayToSelect($characters, 'id', 'name', 'Select a character');

		$this->setViewData('typesArray', $typesArray);
		$this->setViewData('users', $users);
		$this->setViewData('characters', $characters);
	}

	public function postSearch()
	{
		$searchTerm = Input::get('keyword');

		$posts   = Forum_View::where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('content', 'LIKE', '%'. $searchTerm .'%')->paginate(20);

		$typesArray = [
			'all'         => 'All types',
			'Forum_Post'  => 'Post',
			'Forum_Reply' => 'Reply'
		];

		$users = User::orderByNameAsc()->get();
		$users = $this->arrayToSelect($users, 'id', 'username', 'Select a user');

		$characters = Character::orderByNameAsc()->get();
		$enemies    = Enemy::orderByNameAsc()->get();
		$entities   = Entity::orderByNameAsc()->get();
		$creatures  = Creature::orderByNameAsc()->get();

		$characters->merge($enemies)->merge($entities)->merge($creatures);
		$characters = $this->arrayToSelect($characters, 'id', 'name', 'Select a character');

		$this->setViewData('typesArray', $typesArray);
		$this->setViewData('users', $users);
		$this->setViewData('characters', $characters);
		$this->setViewData('posts', $posts);
	}

	public function getSearchResults()
	{
		$searchTerm = Input::get('keyword');
		$type       = Input::get('type');
		$user       = Input::get('user');
		$character  = Input::get('character');

		$posts   = Forum_View::orderBy('lastModified', 'desc');

		if ($user != '0') {
			$posts->where('user_id', $user);
		}

		if ($character != '0') {
			$posts->where('morph_id', $character);
		}

		if ($type != 'all') {
			$posts->where('type', $type);
		}

		if ($searchTerm != '') {
			if ($user != '0' || $character != '0' || $type != 'all') {
				$posts->where(function ($query) use ($searchTerm) {
					$query->where('name', 'LIKE', '%'. $searchTerm .'%');
					$query->orWhere('content', 'LIKE', '%'. $searchTerm .'%');
				});
			} else {
				$posts->where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('content', 'LIKE', '%'. $searchTerm .'%');
			}
		}

		$posts = $posts->paginate(20);

		$this->setViewData('posts', $posts);
	}
}