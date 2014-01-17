<?php

class Helper_Forum extends Helper_Message {

	protected function moveForumCategoriestable()
	{
		if ($this->confirm('Do you wish to move forum categories? [yes|no]')) {
			// Move the categories
			$this->addOldIdColumn('forum_categories');

			$categories = DB::table('stygian_main.forum_categories')->get();

			foreach ($categories as $object) {
				if ($object->name == 'Firefly: After Miranda') continue;

				$newObject                         = new Forum_Category;
				$newObject->name                   = $object->name;
				$newObject->keyName                = $object->keyName;
				$newObject->description            = $object->description;
				$newObject->position               = $object->position;
				$newObject->forum_category_type_id = 1;
				$newObject->created_at             = $object->created_at;
				$newObject->updated_at             = $object->updated_at;
				$newObject->oldId                  = $object->id;

				$newObject->save();
			}
			$this->info('Categories moved');
		} else {
			$this->info('Categories skipped');
		}
	}

	protected function moveForumBoardstable()
	{
		if ($this->confirm('Do you wish to move boards? [yes|no]')) {
			// Move the boards
			$this->addOldIdColumn('forum_boards');

			$boards = DB::table('stygian_main.forum_boards')->get();

			foreach ($boards as $object) {
				$existingBoard = Forum_Board::where('oldId', $object->id)->first();

				if ($existingBoard == null) {
					$categoryId = $this->getIdForOldId('Forum_Category', $object->forum_category_id);

					if ($categoryId == '0') continue;

					$newObject                      = new Forum_Board;
					$newObject->name                = $object->name;
					$newObject->keyName             = $object->keyName;
					$newObject->description         = $object->description;
					$newObject->position            = $object->position;
					$newObject->parent_id           = $object->parent_id;
					$newObject->forum_board_type_id = 1;
					$newObject->forum_category_id   = $categoryId;
					$newObject->created_at          = $object->created_at;
					$newObject->updated_at          = $object->updated_at;
					$newObject->oldId               = $object->id;

					$newObject->save();
				}
			}

			// Set board parents
			$boards = Forum_Board::all();

			foreach ($boards as $board) {
				if ($board->parent_id == '0') {
					$board->parent_id = null;
				} else {
					$board->parent_id = $this->getIdForOldId('Forum_Board', $board->parent_id);
				}
				$board->save();
			}
			$this->info('Boards moved');
		} else {
			$this->info('Boards skipped');
		}
	}

	protected function moveForumPoststable()
	{
		if ($this->confirm('Do you wish to move posts? [yes|no]')) {
			// Move the posts
			$this->addOldIdColumn('forum_posts');

			$posts = DB::table('stygian_main.forum_posts')->get();

			foreach ($posts as $object) {
				// Check for existing entry
				$existingPosts = $this->getIdForOldId('Forum_Post', $object->id);

				if ($existingPosts != '0') continue;

				$boardId = $this->getIdForOldId('Forum_Board', $object->forum_board_id);

				if ($boardId == '0') continue;

				$character = $this->findCharacterById($object->character_id);
				$newObject                      = new Forum_Post;
				$newObject->name                = $object->name;
				$newObject->keyName             = $object->keyName;
				$newObject->content             = $object->content;
				$newObject->views               = $object->views;
				$newObject->morph_id            = !is_null($character) ? $character->id : null;
				if ($newObject->morph_id != null) {
					$newObject->morph_type      = getRootClass($character);
				}
				$newObject->forum_post_type_id  = 1;
				$newObject->forum_board_id      = $boardId;
				$newObject->user_id             = $this->getIdForOldId('User', $object->user_id);
				$newObject->created_at          = $object->created_at;
				$newObject->updated_at          = $object->updated_at;
				$newObject->modified_at         = $object->modified_at;
				$newObject->approvedFlag        = $object->approvedFlag;
				$newObject->frontPageFlag       = $object->frontPageFlag;
				$newObject->moderatorLockedFlag = $object->moderatorLockedFlag;
				$newObject->oldId               = $object->id;

				$newObject->save();
			}
			$this->info('Posts moved');
		} else {
			$this->info('Posts skipped');
		}
	}

	protected function moveForumRepliestable()
	{
		if ($this->confirm('Do you wish to move replies? [yes|no]')) {
			// Move the replies
			$this->addOldIdColumn('forum_replies');

			$replies = DB::table('stygian_main.forum_replies')->get();

			foreach ($replies as $object) {
				// check for existing entry
				$existingPosts = $this->getIdForOldId('Forum_Reply', $object->id);

				if ($existingPosts != '0') continue;

				$postId = $this->getIdForOldId('Forum_Post', $object->forum_post_id);

				if ($postId == '0') continue;

				$character = $this->findCharacterById($object->character_id);
				$newObject                      = new Forum_Reply;
				$newObject->name                = $object->name;
				$newObject->keyName             = $object->keyName;
				$newObject->content             = $object->content;
				$newObject->quote_id            = $object->quote_id;
				$newObject->quote_type          = $object->quote_type;
				$newObject->morph_id            = !is_null($character) ? $character->id : null;
				if ($newObject->morph_id != null) {
					$newObject->morph_type      = getRootClass($character);
				}
				$newObject->forum_reply_type_id = 1;
				$newObject->forum_post_id       = $postId;
				$newObject->user_id             = $this->getIdForOldId('User', $object->user_id);
				$newObject->created_at          = $object->created_at;
				$newObject->updated_at          = $object->updated_at;
				$newObject->approvedFlag        = $object->approvedFlag;
				$newObject->moderatorLockedFlag = $object->moderatorLockedFlag;
				$newObject->oldId               = $object->id;

				$newObject->save();
			}
			$this->info('Replies moved');
		} else {
			$this->info('Replies skipped');
		}
	}

	protected function moveForumPostEditsTable()
	{
		if ($this->confirm('Do you wish to move post edits? [yes|no]')) {
			// Move the post edits
			$postEdits = DB::table('stygian_main.forum_post_edits')->get();

			foreach ($postEdits as $object) {
				$postId = $this->getIdForOldId('Forum_Post', $object->forum_post_id);

				if ($postId == '0') continue;

				$newObject                = new Forum_Post_Edit;
				$newObject->forum_post_id = $postId;
				$newObject->user_id       = $this->getIdForOldId('User', $object->user_id);
				$newObject->reason        = $object->reason;
				$newObject->created_at    = $object->created_at;
				$newObject->updated_at    = $object->updated_at;

				$newObject->save();
			}
			$this->info('Post edits moved');
		} else {
			$this->info('Post edits skipped');
		}
	}

	protected function moveForumReplyEditsTable()
	{
		if ($this->confirm('Do you wish to move reply edits? [yes|no]')) {
			// Move the reply edits
			$replyEdits = DB::table('stygian_main.forum_reply_edits')->get();

			foreach ($replyEdits as $object) {
				$replyId = $this->getIdForOldId('Forum_Reply', $object->forum_reply_id);

				if ($replyId == '0') continue;

				$newObject                 = new Forum_Reply_Edit;
				$newObject->forum_reply_id = $replyId;
				$newObject->user_id        = $this->getIdForOldId('User', $object->user_id);
				$newObject->reason         = $object->reason;
				$newObject->created_at     = $object->created_at;
				$newObject->updated_at     = $object->updated_at;

				$newObject->save();
			}
			$this->info('Reply edits moved');
		} else {
			$this->info('Reply edits skipped');
		}
	}

	protected function moveForumPostStatusesTable()
	{
		if ($this->confirm('Do you wish to move post statuses? [yes|no]')) {
			// Move the post status
			$postStatuses = DB::table('stygian_main.forum_post_status')->get();

			foreach ($postStatuses as $object) {
				$postId = $this->getIdForOldId('Forum_Post', $object->forum_post_id);

				if ($postId == '0') continue;

				$newObject                          = new Forum_Post_Status;
				$newObject->forum_post_id           = $postId;
				$newObject->forum_support_status_id = $object->forum_support_status_id;
				$newObject->created_at              = $object->created_at;
				$newObject->updated_at              = $object->updated_at;

				$newObject->save();
			}
			$this->info('Post statuses moved');
		} else {
			$this->info('Post statuses skipped');
		}
	}

	protected function moveForumPostViewsTable()
	{
		if ($this->confirm('Do you wish to move post views? [yes|no]')) {
			// Move the user viewed posts
			$postViewed = DB::table('stygian_main.forum_user_view_posts')->get();

			foreach ($postViewed as $object) {
				$postId = $this->getIdForOldId('Forum_Post', $object->forum_post_id);
				$userId = $this->getIdForOldId('User', $object->user_id);

				$existingView = Forum_Post_View::where('forum_post_id', $postId)->where('user_id', $userId)->first();

				if ($existingView == null) {
					$newObject                = new Forum_Post_View;
					$newObject->forum_post_id = $postId;
					$newObject->user_id       = $userId;
					$newObject->created_at    = $object->created_at;
					$newObject->updated_at    = $object->updated_at;

					$newObject->save();
				}
			}
			$this->info('Post views moved');
		} else {
			$this->info('Post views skipped');
		}
	}
}