<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

        $users = json_decode(file_get_contents(storage_path('group_user.json')));

        foreach ($pair as $match) {
            $usr_grp = new GroupUser;
            $usr_grp->user_id = $match->user_id;
            $usr_grp->group_id = $match->group_id;
            $usr_grp->save();
        }//
    }
}
