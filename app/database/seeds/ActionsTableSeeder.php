<?php

class ActionsTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('actions')->truncate();

        $actions = array(
            array(
                'name' => 'Create Chat Rooms',
                'keyName' => 'CHAT_CREATE',
                'description' =>'Grants the ability to create new chat rooms.'
            ),
            array(
                'name' => 'Forum Access',
                'keyName' => 'FORUM_ACCESS',
                'description' => 'Ability to view the forums.'
            ),
            array(
                'name' => 'Forum Administration',
                'keyName' => 'FORUM_ADMIN',
                'description' => 'Ability to access the admin panel in the forums.'
            ),
            array(
                'name' => 'Forum Moderation',
                'keyName' => 'FORUM_MOD',
                'description' => 'Ability to access the moderator panel.'
            ),
            // 5
            array(
                'name' => 'Forum Post',
                'keyName' => 'FORUM_POST',
                'description' => 'Ability to post in the forums.'
            ),
            array(
                'name' => 'Promote to front page',
                'keyName' => 'PROMOTE_FRONT_PAGE',
                'description' => 'Grants the ability to promote a forum post to the front page.'
            ),
            array(
                'name' => 'Game Master',
                'keyName' => 'GAME_MASTER',
                'description' => ''
            ),
            array(
                'name' => 'Create Games',
                'keyName' => 'CREATE_GAMES',
                'description' => 'Grants the ability to create new games.'
            ),
            array(
                'name' => 'Run Games',
                'keyName' => 'RUN_GAMES',
                'description' => 'Grants the ability to run games.'
            ),
        );

        // Uncomment the below to run the seeder
        DB::table('actions')->insert($actions);
    }

}