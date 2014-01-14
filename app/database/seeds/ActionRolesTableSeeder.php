<?php

class ActionRolesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('action_roles')->truncate();

        $action_roles = array(
            // Site Admin
            array('action_id' => '1', 'role_id' => '1'),
            array('action_id' => '2', 'role_id' => '1'),
            array('action_id' => '3', 'role_id' => '1'),
            array('action_id' => '4', 'role_id' => '1'),
            array('action_id' => '5', 'role_id' => '1'),
            array('action_id' => '6', 'role_id' => '1'),
            array('action_id' => '7', 'role_id' => '1'),
            array('action_id' => '8', 'role_id' => '1'),
            array('action_id' => '9', 'role_id' => '1'),
            // Forum Guest
            array('action_id' => '2', 'role_id' => '3'),
            // Forum Member
            array('action_id' => '2', 'role_id' => '4'),
            array('action_id' => '5', 'role_id' => '4'),
            // Forum Moderator
            array('action_id' => '2', 'role_id' => '5'),
            array('action_id' => '5', 'role_id' => '5'),
            array('action_id' => '4', 'role_id' => '5'),
            // Forum Administrator
            array('action_id' => '2', 'role_id' => '6'),
            array('action_id' => '3', 'role_id' => '6'),
            array('action_id' => '5', 'role_id' => '6'),
            array('action_id' => '4', 'role_id' => '6'),
            array('action_id' => '6', 'role_id' => '6'),
            // Game Master
            array('action_id' => '1', 'role_id' => '7'),
            array('action_id' => '8', 'role_id' => '7'),
            array('action_id' => '7', 'role_id' => '7'),
            array('action_id' => '6', 'role_id' => '7'),
            array('action_id' => '9', 'role_id' => '7'),
            // Game StoryTeller
            array('action_id' => '1', 'role_id' => '9'),
            array('action_id' => '6', 'role_id' => '9'),
            array('action_id' => '9', 'role_id' => '9'),
        );

        // Uncomment the below to run the seeder
        DB::table('action_roles')->insert($action_roles);
    }

}