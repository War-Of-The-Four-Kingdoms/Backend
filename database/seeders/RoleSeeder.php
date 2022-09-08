<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'king', 'extra_hp' => true],
            ['name' => 'knight', 'extra_hp' => false],
            ['name' => 'noble', 'extra_hp' => false],
            ['name' => 'villager', 'extra_hp' => false],
        ]);
    }
}
