<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'test1','email' => 'test1@mail.com','password' => bcrypt('123456'),'uuid' => uniqid()],
            ['name' => 'test2','email' => 'test2@mail.com','password' => bcrypt('123456'),'uuid' => uniqid()],
            ['name' => 'test3','email' => 'test3@mail.com','password' => bcrypt('123456'),'uuid' => uniqid()],
            ['name' => 'test4','email' => 'test4@mail.com','password' => bcrypt('123456'),'uuid' => uniqid()],
        ]);
    }
}
