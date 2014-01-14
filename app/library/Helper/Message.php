<?php

class Helper_Message extends Helper {

	protected function createUserInboxes()
	{
		if ($this->confirm('Do you wish to create user inboxes? [yes|no]')) {
			// Create inboxes for all the users
			$users = User::all();

			foreach ($users as $object) {
				if ($object->inbox == null) {
					$newObject            = new Message_Folder;
					$newObject->user_id   = $object->id;
					$newObject->parent_id = null;
					$newObject->name      = 'Inbox';

					$newObject->save();
				}
			}
			$this->info('User inboxes moved');
		} else {
			$this->info('User inboxes skipped');
		}
	}

	protected function moveMessagesFoldersTable()
	{
		if ($this->confirm('Do you wish to move message folder? [yes|no]')) {
			// Move the message folders
			$this->addOldIdColumn('message_folders');

			$messageFolders = DB::table('stygian_main.message_folders')->get();

			foreach ($messageFolders as $object) {
				$user                  = User::where('oldId', $object->user_id)->first();

				$newObject             = new Message_Folder;
				$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
				$newObject->parent_id  = $user->inbox;
				$newObject->name       = $object->name;
				$newObject->created_at = $object->created_at;
				$newObject->updated_at = $object->updated_at;
				$newObject->oldId      = $object->id;

				$newObject->save();
			}
			$this->info('Message folders moved');
		} else {
			$this->info('Message folders skipped');
		}
	}

	protected function setMessageTypes()
	{
		if ($this->confirm('Do you wish to move message types? [yes|no]')) {
			// Match the message types
			$messageTypes = DB::table('stygian_main.message_types')->get();

			foreach ($messageTypes as $object) {
				$existingType = Message_Type::where('name', $object->name)->first();

				if ($existingType == null) {
					$newObject              = new Message_Type;
					$newObject->id          = $object->id;
					$newObject->name        = $object->name;
					$newObject->keyName     = $object->keyName;
					$newObject->description = $object->description;
					$newObject->created_at  = $object->created_at;
					$newObject->updated_at  = $object->updated_at;

					$newObject->save();
				}
			}
			$this->info('Message types moved');
		} else {
			$this->info('Message types skipped');
		}
	}

	protected function moveMessagesTable()
	{
		if ($this->confirm('Do you wish to move messages? [yes|no]')) {
			// Move the messages
			$this->addOldIdColumn('messages');

			$messages = DB::table('stygian_main.messages')->get();

			foreach ($messages as $object) {
				$existingMessage = Message::where('oldId', $object->id)->first();

				if ($existingMessage == null) {
					$newObject                  = new Message;
					$newObject->sender_id       = $this->getIdForOldId('User', $object->sender_id);
					$newObject->receiver_id     = $this->getIdForOldId('User', $object->receiver_id);
					$newObject->message_type_id = $object->message_type_id;
					$newObject->parent_id       = $object->parent_id;
					$newObject->child_id        = $object->child_id;
					$newObject->title           = $object->title;
					$newObject->content         = $object->content;
					$newObject->created_at      = $object->created_at;
					$newObject->updated_at      = $object->updated_at;
					$newObject->oldId           = $object->id;

					$newObject->save();

					// Mark the message read
					// $messageRead             = new Message_User_Read;
					// $messageRead->user_id    = $newObject->receiver_id;
					// $messageRead->message_id = $newObject->id;

					// $messageRead->save();
				}
			}

			// Set message parents and children
			$messages = Message::all();

			foreach ($messages as $message) {
				if ($message->parent_id != null) {
					$message->parent_id = $this->getIdForOldId('Message', $message->parent_id);
				}
				if ($message->child_id != null) {
					$message->child_id  = $this->getIdForOldId('Message', $message->child_id);
				}

				$message->save();
			}
			$this->info('Messages moved');
		} else {
			$this->info('Messages skipped');
		}
	}

	protected function moveMessageDeletes()
	{
		if ($this->confirm('Do you wish to move message deletes? [yes|no]')) {
			// Move the message deletes
			$messageDeletes = DB::table('stygian_main.message_user_deleted')->get();

			foreach ($messageDeletes as $object) {
				// Mark the message read
				$newObject             = new Message_User_Delete;
				$newObject->user_id    = $this->getIdForOldId('User', $object->user_id);
				$newObject->message_id = $this->getIdForOldId('Message', $object->message_id);
				$newObject->created_at = $object->created_at;
				$newObject->updated_at = $object->updated_at;

				$newObject->save();
			}
			$this->info('Messages deletes moved');
		} else {
			$this->info('Messages deletes skipped');
		}
	}

	protected function moveMessagesToInboxes()
	{
		if ($this->confirm('Do you wish to move all messages into inboxes? [yes|no]')) {
			// Make sure every message is in a folder
			$messages = Message::all();

			foreach ($messages as $message) {
				if ($message->receiver_id != $message->sender_id) {
					$newFolder             = new Message_Folder_Message;
					$newFolder->folder_id  = $message->receiver->inbox;
					$newFolder->user_id    = $message->receiver_id;
					$newFolder->message_id = $message->id;

					$newFolder->save();
				}

				// if ($message->receiver_id != $message->sender_id) {
				// 	$newFolder             = new Message_Folder_Message;
				// 	$newFolder->folder_id  = $message->sender->inbox;
				// 	$newFolder->user_id    = $message->sender_id;
				// 	$newFolder->message_id = $message->id;

				// 	$newFolder->save();
				// }
			}
			$this->info('Move messages into inboxes completed');
		} else {
			$this->info('Move messages into inboxes skipped');
		}
	}
}