<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // DELETE ALL DATA
        DB::table('group_user')->truncate();

        $pair = json_decode(file_get_contents(storage_path('group_user.json')));


        foreach($pair as $match){
            DB::table('group_user')->insert([
                'user_id' => $match->user_id,
                'group_id' => $match->group_id
            ]);
        }
    }
}
