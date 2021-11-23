<?php

namespace Database\Seeders;

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
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VenueSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(CategoryEventSeeder::class);
        //$this->call(UserChoiceSeeder::class);
        //$this->call(SearchSessionSeeder::class);
        $this->call(GroupUserSeeder::class);
        $this->call(GroupSeeder::class);




    }
}
