<?php

class Magic_Tree extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'magic_trees';
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
		'magic_type_id' => 'required|exists:magic_types,uniqueId'
	);

	/********************************************************************
	 * Scopes
	 *******************************************************************/

	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'type'   => array('belongsTo',	'Magic_Type',	'foreignKey' => 'magic_type_id'),
		'spells' => array('hasMany',	'Magic_Spell',	'foreignKey' => 'magic_tree_id'),
		'morph'  => array('morphTo'),
	);

	/********************************************************************
	 * Model Events
	 *******************************************************************/

	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getCharacterCreatedATtribute()
	{
		if ($this->morph_id != null) {
			if (isset($this->morph->name)) {
				return $this->morph->name;
			}
		}

		return null;
	}

	public function getApprovedAttribute()
	{
		return $this->approvedFlag == 1 ? 'Yes' : null;
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}