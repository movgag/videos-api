<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'User 1',
                'email' => 'user1@test.com',
                'username' => 'user1',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@test.com',
                'username' => 'user2',
                'password' => bcrypt('123456'),
            ],
        ];
        DB::table('users')->insert($data);
    }
}
