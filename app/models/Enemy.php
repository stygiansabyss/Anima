<?php

class Enemy extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'enemies';
	protected $primaryKey = 'uniqueId';
	public $incrementing  = false;

	/**
	 * Soft Delete users instead of completely removing them
	 *
	 * @var bool $softDelete Whether to delete or soft delete
	 */
	protected $softDelete = true;
	
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
		'name'      => 'required|max:200',
		'user_id'   => 'required|exists:users,uniqueId',
		'parent_id' => 'exists:characters,uniqueId',
		'horde_id'  => 'exists:hordes,uniqueId',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'user'                => array('belongsTo',	'User',							'foreignKey' => 'user_id'),
		'parent'              => array('belongsTo',	'Character',					'foreignKey' => 'parent_id'),
		'details'             => array('morphOne',	'Character_Detail',				'name'       => 'morph'),
		'items'               => array('morphMany',	'Item_Character',				'name'       => 'morph'),
		'games'               => array('morphMany',	'Game_Character',				'name'       => 'morph'),
		'customTrees'         => array('morphMany',	'Magic_Tree',					'name'       => 'morph'),
		'customSpells'        => array('morphMany',	'Magic_Spell',					'name'       => 'morph'),
		'spells'              => array('morphMany',	'Character_Spell',				'name'       => 'morph'),
		'stats'               => array('morphMany',	'Character_Stat',				'name'       => 'morph'),
		'traits'              => array('morphMany',	'Character_Trait',				'name'       => 'morph'),
		'skills'              => array('morphMany',	'Character_Skill',				'name'       => 'morph'),
		'secondaryAttributes' => array('morphMany',	'Character_Attribute_Secondary','name'       => 'morph'),
		'attributes'          => array('morphMany',	'Character_Attribute',			'name'       => 'morph'),
		'appearances'         => array('morphMany',	'Character_Appearance',			'name'       => 'morph'),
		'class'               => array('morphOne',	'Character_Class',				'name'       => 'morph'),
	);
	
	/********************************************************************
	 * Model Events
	 *******************************************************************/
	
	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getRaceAttribute()
	{
		$race = $this->stats->filter(function ($stat) {
			if ($stat->stat->name == 'Race') {
				return true;
			}
		});

		return $race->value;
	}

	public function getAdvantagesAttribute()
	{
		$advantages = $this->traits->filter(function ($trait) {
			if ($trait->trait->advantageFlag == 1) {
				return true;
			}
		});

		return $advantages;
	}

	public function getDisadvantagesAttribute()
	{
		$disadvantages = $this->traits->filter(function ($trait) {
			if ($trait->trait->advantageFlag == 0) {
				return true;
			}
		});

		return $disadvantages;
	}
	
	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}