<?php

class Character_Attribute_Secondary extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'character_secondary_attributes';
	
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
		'morph_id'     => 'required',
		'morph_type'   => 'required',
		'attribute_id' => 'exists:secondary_attributes,uniqueId',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'attribute' => array('belongsTo', 'Attribute_Secondary', 'foreignKey' => 'attribute_id'),
		'morph'     => array('morphTo'),
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