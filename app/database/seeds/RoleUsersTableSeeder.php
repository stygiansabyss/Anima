<?php

class RoleUsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('role_users')->truncate();

        $role_users = array(
            array('role_id' => 2, 'user_id' => '2bHAJwWCX2'),
            array('role_id' => 4, 'user_id' => '5EX3bBl1cD'),
            array('role_id' => 8, 'user_id' => '5EX3bBl1cD'),
            array('role_id' => 4, 'user_id' => 'nyyQ5S3Qv2'),
            array('role_id' => 1, 'user_id' => 'H3RC3aguPg'),
            array('role_id' => 6, 'user_id' => 'H3RC3aguPg'),
            array('role_id' => 8, 'user_id' => 'H3RC3aguPg'),
            array('role_id' => 4, 'user_id' => 'RN1tiYy6g3'),
            array('role_id' => 8, 'user_id' => 'RN1tiYy6g3'),
            array('role_id' => 4, 'user_id' => 'p2ndhUFGdi'),
            array('role_id' => 8, 'user_id' => 'p2ndhUFGdi'),
            array('role_id' => 4, 'user_id' => 'DjguQl7w7D'),
            array('role_id' => 8, 'user_id' => 'DjguQl7w7D'),
            array('role_id' => 4, 'user_id' => 'JNtcWfPeuP'),
            array('role_id' => 8, 'user_id' => 'JNtcWfPeuP'),
            array('role_id' => 4, 'user_id' => 'OzWjwHHKX0'),
            array('role_id' => 8, 'user_id' => 'OzWjwHHKX0'),
            array('role_id' => 4, 'user_id' => 'QBZyZawSDi'),
            array('role_id' => 8, 'user_id' => 'QBZyZawSDi'),
            array('role_id' => 4, 'user_id' => 'tbYwle23Gg'),
            array('role_id' => 8, 'user_id' => 'tbYwle23Gg'),
            array('role_id' => 4, 'user_id' => '2doGA6vDYo'),
            array('role_id' => 8, 'user_id' => '2doGA6vDYo'),
            array('role_id' => 4, 'user_id' => 'j15Esttn8s'),
            array('role_id' => 8, 'user_id' => 'j15Esttn8s'),
            array('role_id' => 4, 'user_id' => 's3MSyKpNWE'),
            array('role_id' => 8, 'user_id' => 's3MSyKpNWE'),
            array('role_id' => 4, 'user_id' => 'uSynQ8QLMp'),
            array('role_id' => 8, 'user_id' => 'uSynQ8QLMp'),
            array('role_id' => 4, 'user_id' => 'Wg9zQMaYmr'),
            array('role_id' => 8, 'user_id' => 'Wg9zQMaYmr'),
            array('role_id' => 4, 'user_id' => 'hqDDaKVvJJ'),
            array('role_id' => 8, 'user_id' => 'hqDDaKVvJJ'),
            array('role_id' => 4, 'user_id' => 'we7XVmfuDX'),
            array('role_id' => 4, 'user_id' => 'dMOfmvgh9C'),
            array('role_id' => 8, 'user_id' => 'dMOfmvgh9C'),
            array('role_id' => 4, 'user_id' => 'Vf0Vyn9zQ8'),
            array('role_id' => 8, 'user_id' => 'Vf0Vyn9zQ8'),
            array('role_id' => 4, 'user_id' => 'W3ehSUz0fI'),
            array('role_id' => 8, 'user_id' => 'W3ehSUz0fI'),
            array('role_id' => 4, 'user_id' => 'uwMroN04mt'),
            array('role_id' => 8, 'user_id' => 'uwMroN04mt'),
            array('role_id' => 4, 'user_id' => 'eWNkjrYV4e'),
            array('role_id' => 8, 'user_id' => 'eWNkjrYV4e'),
            array('role_id' => 4, 'user_id' => 'eWjYo3M7cC'),
            array('role_id' => 8, 'user_id' => 'eWjYo3M7cC'),
            array('role_id' => 4, 'user_id' => 'SRC6D94x6m'),
            array('role_id' => 8, 'user_id' => 'SRC6D94x6m'),
            array('role_id' => 4, 'user_id' => 'Bl3qkkJJcP'),
            array('role_id' => 4, 'user_id' => 'vPakfo9gSF'),
            array('role_id' => 6, 'user_id' => 'mFG1lmTzaM'),
            array('role_id' => 7, 'user_id' => 'mFG1lmTzaM'),
            array('role_id' => 4, 'user_id' => 'i0YAI8eSWe'),
            array('role_id' => 8, 'user_id' => 'i0YAI8eSWe'),
            array('role_id' => 1, 'user_id' => 'PqMqiTKbaR'),
            array('role_id' => 6, 'user_id' => 'PqMqiTKbaR'),
            array('role_id' => 7, 'user_id' => 'PqMqiTKbaR'),
            array('role_id' => 1, 'user_id' => 'bmeJBz10K2'),
            array('role_id' => 2, 'user_id' => 'bmeJBz10K2'),
        );

        // Uncomment the below to run the seeder
        DB::table('role_users')->insert($role_users);
    }

}