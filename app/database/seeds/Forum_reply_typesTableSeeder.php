<?php

class Forum_reply_typesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('forum_reply_types')->truncate();

        $forum_reply_types = array(
        	array(
	        	'name' => 'Standard',
	        	'keyName' => 'standard',
	        	'description' => 'Normal Category.',
	        	'created_at' => date('Y-m-d H:i:s')
	        ),
        	array(
	        	'name' => 'Conversation',
	        	'keyName' => 'conversation',
	        	'description' => 'A post or reply that is mainly dialog.',
	        	'created_at' => date('Y-m-d H:i:s')
	        ),
        	array(
	        	'name' => 'Inner Thought',
	        	'keyName' => 'inner-thought',
	        	'description' => 'A post or reply that contains internal dialog.',
	        	'created_at' => date('Y-m-d H:i:s')
	        ),
        	array(
	        	'name' => 'Action',
	        	'keyName' => 'action',
	        	'description' => 'A post or reply that contains actions.  Will allow the user to roll dice for the action.',
	        	'created_at' => date('Y-m-d H:i:s')
	        ),
        );

        // Uncomment the below to run the seeder
        DB::table('forum_reply_types')->insert($forum_reply_types);
    }

}