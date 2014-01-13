<?php

class Item extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'game_items';
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
		'name'           => 'required|max:200',
		'item_rarity_id' => 'required|exists:game_item_rarities,id',
	);

	/********************************************************************
	 * Scopes
	 *******************************************************************/

	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'rarity'  => array('belongsTo',	'Item_Rarity',		'foreignKey' => 'item_rarity_id'),
		'ownedBy' => array('hasMany',	'Item_Character',	'foreignKey' => 'item_id'),
	);

	/********************************************************************
	 * Model Events
	 *******************************************************************/

	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getRarityLevelAttribute()
	{
		return $this->rarity->name;
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}