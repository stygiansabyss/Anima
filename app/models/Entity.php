<?php

class Entity extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'entities';
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
		'posts'               => array('morphMany',	'Forum_Post',					'name'       => 'morph'),
		'replies'             => array('morphMany',	'Forum_Reply',					'name'       => 'morph'),
	);
	
	/********************************************************************
	 * Model Events
	 *******************************************************************/
	
	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getAvatarAttribute()
	{
		if (File::exists(public_path() .'/img/avatars/Entity/'. Str::studly($this->name) .'.png')) {
			return '/img/avatars/Entity/'. Str::studly($this->name) .'.png';
		}

		return null;
	}
	public function getClassNameAttribute()
	{
		return null;
	}
	
	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
}