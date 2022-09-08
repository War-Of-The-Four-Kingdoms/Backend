<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Face;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            CharacterSeeder::class,
            CardSeeder::class,
            AccessorySeeder::class,
            SkintoneSeeder::class,
            TopSeeder::class,
            FaceSeeder::class,
            HairSeeder::class
        ]);
    }
}
