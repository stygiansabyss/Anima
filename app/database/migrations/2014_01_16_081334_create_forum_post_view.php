<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumPostView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('
			CREATE VIEW forum_view
				AS SELECT
					p.uniqueId as uniqueId, 
					\'Forum_Post\' as type,
					p.forum_post_type_id as type_id,
					p.user_id as user_id,
					p.morph_id as morph_id,
					p.morph_type as morph_type,
					p.name as name,
					p.keyName as keyName,
					p.content as content,
					p.created_at as created_at,
					p.modified_at as lastModified,
					p.deleted_at as deleted_at
				FROM forum_posts p
				UNION SELECT
					r.uniqueId as uniqueId,
					\'Forum_Reply\' as type,
					r.forum_reply_type_id as type_id,
					r.user_id as user_id,
					r.morph_id as morph_id,
					r.morph_type as morph_type,
					r.name as name,
					r.keyName as keyName,
					r.content as content,
					r.created_at as created_at,
					r.updated_at as lastModified,
					r.deleted_at as deleted_at
				FROM forum_replies r
		');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forum_view');
	}

}
