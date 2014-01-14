<?php

class Game_Event extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'game_events';
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
		'week'           => 'required',
		'details'        => 'required'
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	
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