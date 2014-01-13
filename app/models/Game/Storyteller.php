<?php

class Game_Storyteller extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table = 'game_storytellers';
	
	/********************************************************************
	 * Aware validation rules
	 *******************************************************************/
	/**
	 * Validation rules
	 *
	 * @static
	 * @var array $rules All rules this model must follow
	 */
	public static $rules = array(
		'game_id'    => 'required|exists:games,uniqueId',
		'user_id'    => 'required|exists:users,uniqueId',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'user' => array('belongsTo',	'User',		'foreignKey' => 'user_id'),
		'game' => array('belongsTo',	'Game',		'foreignKey' => 'game_id'),
		'morph' => array('morphTo'),
	);
	
	/********************************************************************
	 * Model Events
	 *******************************************************************/
	
	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	
	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}