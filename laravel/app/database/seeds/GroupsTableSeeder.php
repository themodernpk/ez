<?php
/**
 * Created by PhpStorm.
 * User: pradeep
 * Date: 2014-12-14
 * Time: 03:21 PM
 */

class GroupsTableSeeder extends Seeder
{

    public function run()
    {
        $users = [
            [   'name' => 'Admin',
                'slug' => 'admin',
                'active' => 1,
                'created_at' => Dates::now(),
                'updated_at' => Dates::now(),
            ],
            [   'name' => 'Registered',
                'slug' => 'registered',
                'active' => 1,
                'created_at' => Dates::now(),
                'updated_at' => Dates::now(),
            ]
        ];

        DB::table('groups')->insert($users);

    }

}