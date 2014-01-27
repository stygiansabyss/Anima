<?php

class Character extends BaseCharacter {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'characters';
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
		'status'              => array('morphMany',	'Character_Status',				'name'       => 'morph'),
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
	public function addExperience($exp, $userId, $reason = null, $resource_type = null, $resource_id = null)
	{
		$this->details->experience = $this->details->experience + $exp;
		$this->details->save();

		// Add the exp to the log
		$expHistory                = new Character_Experience_History;
		$expHistory->morph_id      = $this->id;
		$expHistory->morph_type    = 'Character';
		$expHistory->user_id       = $userId;
		$expHistory->value         = $exp;
		$expHistory->reason        = $reason;
		$expHistory->resource_id   = $resource_id;
		$expHistory->resource_type = getRootClass($resource_type);
		$expHistory->balance       = $this->details->experience;
		$expHistory->save();

		if ($resource_type == null) {
			$message                  = new Message;
			$message->message_type_id = Message::EXPERIENCE;
			$message->sender_id       = $userId;
			$message->receiver_id     = $this->user_id;
			$message->title           = 'You gained experience points!';
			$message->content         = 'You were granted '. $exp .' experience points. <br /><br /> '.$reason .'<br /><br />Your character now has '. $this->experience .' experience points total';
			$message->save();
		} else {
			$message                  = new Message;
			$message->message_type_id = Message::EXPERIENCE;
			$message->sender_id       = $userId;
			$message->receiver_id     = $this->user_id;
			$message->title           = 'You gained experience points!';
			$message->content         = $this->name .' was granted '. $exp .' experience points. <br /><br /> This was given out for your post found '. $expHistory->resource->name .'.<br /><br />Your character now has '. $this->experience .' experience points total';
			$message->save();
		}

		return true;
	}
}