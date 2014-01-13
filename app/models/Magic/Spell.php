<?php

class Magic_Spell extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'magic_spells';
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
		'name'          => 'required|max:200',
		'magic_tree_id' => 'required|exists:magic_trees,uniqueId'
	);

	/********************************************************************
	 * Scopes
	 *******************************************************************/

	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'attribute'  => array('belongsTo',	'Attribute',		'foreignKey' => 'attribute_id'),
		'tree'       => array('belongsTo',	'Magic_Tree',		'foreignKey' => 'magic_tree_id'),
		'characters' => array('hasMany',	'Character_Spell',	'foreignKey' => 'magic_spell_id'),
		'morph'      => array('morphTo'),
	);

	/********************************************************************
	 * Model Events
	 *******************************************************************/

	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getAttributeNameAttribute()
	{
		return $this->attribute->name;
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}