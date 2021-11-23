<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DELETE ALL DATA
        DB::table('groups')->truncate();

        $groups = json_decode(file_get_contents(storage_path('groups.json')));

        foreach ($groups as $group) {
            $grp = new Group;
            $grp->name = $group->name;
            $grp->owner_id = $group->owner_id;
            $grp->save();
        }
    }
}
