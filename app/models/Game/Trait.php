<?php

class Game_Trait extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'traits';
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
		'name'         => 'required|max:200',
		'minimumValue' => 'required',
		'maximumValue' => 'required',
	);

	/********************************************************************
	 * Scopes
	 *******************************************************************/
	public function scopeOrderByAdvantage($query)
	{
		$query->orderBy('advantageFlag', 'desc');
	}
	public function scopeAdvantage($query)
	{
		$query->where('advantageFlag', 1);
	}
	public function scopeDisadvantage($query)
	{
		$query->where('advantageFlag', 0);
	}

	/********************************************************************
	 * Relationships
	 *******************************************************************/

	/********************************************************************
	 * Model Events
	 *******************************************************************/

	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getTypeAttribute()
	{
		return $this->advantageFlag == 1 ? 'Advantage' : 'Disadvantage';
	}

	public function getRangeAttribute()
	{
		return $this->minimumValue .' - '. $this->maximumValue;
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}