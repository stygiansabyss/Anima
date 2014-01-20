<?php

class Character_Attribute extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'character_attributes';
	
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
		'attribute_id' => 'exists:attributes,uniqueId',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'attribute' => array('belongsTo', 'Attribute', 'foreignKey' => 'attribute_id'),
		'morph'     => array('morphTo'),
	);

	/********************************************************************
	 * Model Events
	 *******************************************************************/
	
	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getModifierAttribute()
	{
		return Attribute_Modifier::where('value', $this->value)->first()->modifier;
	}
	
	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}