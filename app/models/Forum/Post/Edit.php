<?php

class Forum_Post_Edit extends BaseModel
{
	/**
	 * Declarations
	 */
	protected $table = 'forum_post_edits';

	/**
	 * Aware validation rules
	 */
	public static $rules = array(
		'user_id'             => 'required|exists:users,id',
		'forum_post_id'       => 'required|exists:forum_posts,id',
	);

	/**
	 * Getter and Setter methods
	 */

	/**
	 * Relationships
	 */
	public function post()
	{
		return $this->belongsTo('Forum_Post', 'forum_post_id');
	}

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

}