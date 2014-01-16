<?php

class Item_Quest extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'game_quest_items';
	
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
		'quest_id' => 'required|exists:game_quests,uniqueId',
		'item_id'  => 'required|exists:game_items,uniqueId',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'quest' => array('belongsTo', 'Game_Quest',	'foreignKey' => 'quest_id'),
		'item'  => array('belongsTo', 'Item',		'foreignKey' => 'item_id'),
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