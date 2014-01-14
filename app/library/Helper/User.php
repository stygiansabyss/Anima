<?php

class Helper_User extends Helper_Character {

	protected function moveUsersTable()
	{
		if ($this->confirm('Do you wish to move users? [yes|no]')) {
			// Move the characters
			$objects = DB::table('stygian_main.users')->get();

			foreach ($objects as $object) {
				$existingUser = User::where('username', $object->username)->first();

				if (!is_null($existingUser)) {
					$existingUser->oldId = $object->id;
					$existingUser->save();
				} else {
					$newObject             = new User;
					$newObject->username   = $object->username;
					$newObject->password   = 'changeme';
					$newObject->firstName  = $object->firstName;
					$newObject->lastName   = $object->lastName;
					$newObject->email      = $object->email;
					$newObject->lastActive = $object->lastActive;
					$newObject->created_at = $object->created_at;
					$newObject->updated_at = $object->updated_at;
					$newObject->deleted_at = $object->deleted_at;
					$newObject->oldId      = $object->id;

					$newObject->save();
				}
			}
			$this->info('Users moved');
		} else {
			$this->info('Users skipped');
		}
	}
}