<?php

// Let them logout
Route::get('logout', function()
{
	Auth::logout();
	return Redirect::to('/')->with('message', 'You have successfully logged out.');
});

// Non-Secure routes
Route::controller('api' , 'Core_ApiVersionOneController');

// Secure routes
/********************************************************************
 * General
 *******************************************************************/
Route::group(array('before' => 'auth'), function()
{
	Route::controller('user/characters/spells'	, 'User_Character_SpellController');
	Route::controller('user/characters'			, 'User_CharacterController');

	Route::controller('user'					, 'Core_UserController');
	Route::controller('messages'				, 'Core_MessageController');
	Route::controller('chat'					, 'Core_ChatController');
	Route::controller('github'					, 'Core_GithubController');

	Route::controller('character/spell'			, 'Character_SpellController');
	Route::controller('character/tree'			, 'Character_TreeController');
	Route::controller('character'				, 'CharacterController');
});

/********************************************************************
 * Access to game master
 *******************************************************************/
Route::group(array('before' => 'auth|permission:GAME_MASTER'), function()
{
	Route::controller('game/master/rules/core'		, 'Game_Master_Rules_CoreController');
	Route::controller('game/master/rules/modules'	, 'Game_Master_Rules_ModuleController');
	Route::controller('game/master/rules/abilities'	, 'Game_Master_Rules_AbilityController');
	Route::controller('game/master/rules/ki'		, 'Game_Master_Rules_KiController');
	Route::controller('game/master/rules/magic'		, 'Game_Master_Rules_MagicController');
	Route::controller('game/master/rules/psychic'	, 'Game_Master_Rules_PsychicController');
	Route::controller('game/master/rules/summoning'	, 'Game_Master_Rules_SummoningController');
	Route::controller('game/master/rules'			, 'Game_Master_RulesController');

	Route::controller('game/master/games'			, 'Game_Master_GameController');

	Route::controller('game/master/items'			, 'Game_Master_ItemController');

	Route::controller('game/master/character'		, 'Game_Master_CharacterController');
	Route::controller('game/master/enemy'			, 'Game_Master_EnemyController');
	Route::controller('game/master/entity'			, 'Game_Master_EntityController');

	Route::controller('game/master'					, 'Game_MasterController');
});

/********************************************************************
 * Access to forum moderation
 *******************************************************************/
Route::group(array('before' => 'auth|permission:FORUM_MOD'), function()
{
	Route::controller('forum/moderation', 'Core_Forum_ModerationController');
});

/********************************************************************
 * Access to forum administration
 *******************************************************************/
Route::group(array('before' => 'auth|permission:FORUM_ADMIN'), function()
{
	Route::controller('forum/admin', 'Core_Forum_AdminController');
});

/********************************************************************
 * Access to the forums
 *******************************************************************/
Route::group(array('before' => 'auth|permission:FORUM_ACCESS'), function()
{
	Route::controller('forum/post'		, 'Core_Forum_PostController');
	Route::controller('forum/board'		, 'Core_Forum_BoardController');
	Route::controller('forum/category'	, 'Core_Forum_CategoryController');
	Route::controller('forum'			, 'ForumController');
});

/********************************************************************
 * Access to the dev panel
 *******************************************************************/
Route::group(array('before' => 'auth|permission:SITE_ADMIN'), function()
{
	Route::controller('admin', 'AdminController');
});

// Landing page
Route::controller('/', 'HomeController');

require_once('start/local.php');
