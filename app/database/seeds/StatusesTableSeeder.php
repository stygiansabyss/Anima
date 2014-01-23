<?php

class StatusesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('statuses')->truncate();

        $statuses = array(
            array(
                'name'        => 'Active',
                'keyName'     => 'ACTIVE',
                'description' => 'This object is actively being used.'
            ),
            array(
                'name'        => 'Approved',
                'keyName'     => 'APPROVED',
                'description' => 'This character is approved for at least one game.'
            ),
            array(
                'name'        => 'Awaiting Approval',
                'keyName'     => 'AWAITING_APPROVAL',
                'description' => 'This character has applied to join a game but is awaiting approval.'
            ),
            array(
                'name'        => 'Banned',
                'keyName'     => 'BANNED',
                'description' => 'This object is banned from ever being used again.'
            ),
            array(
                'name'        => 'Dead',
                'keyName'     => 'DEAD',
                'description' => 'This character is permanently dead.'
            ),
            array(
                'name'        => 'Hidden',
                'keyName'     => 'HIDDEN',
                'description' => 'The character should be hidden from lists and character sheets.'
            ),
            array(
                'name'        => 'In Progress',
                'keyName'     => 'IN_PROGRESS',
                'description' => 'This character is still being created by the player.'
            ),
            array(
                'name'        => 'Inactive',
                'keyName'     => 'INACTIVE',
                'description' => 'The object is no longer being actively used.'
            ),
            array(
                'name'        => 'NPC',
                'keyName'     => 'NPC',
                'description' => 'This character is not being used by a player.'
            ),
            array(
                'name'        => 'Enemy',
                'keyName'     => 'ENEMY',
                'description' => 'This character is not friendly.'
            ),
        );

        // Uncomment the below to run the seeder
        DB::table('statuses')->insert($statuses);
    }

}