<?php

class Magic_Type extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'magic_types';
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
		'name' => 'required|max:200',
	);

	/********************************************************************
	 * Scopes
	 *******************************************************************/

	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'trees'      => array('hasMany',	'Magic_Tree',	'foreignKey' => 'magic_type_id'),
		'characters' => array('hasMany',	'Character',	'foreignKey' => 'magic_type_id'),
	);

	/********************************************************************
	 * Model Events
	 *******************************************************************/

	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getUserCreatedTreesAttribute()
	{
		return $this->userCreatedTreesFlag == 1 ? 'Yes' : null;
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}