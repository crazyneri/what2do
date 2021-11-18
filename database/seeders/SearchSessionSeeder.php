<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SearchSession;

use DB;

class SearchSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
                DB::table('search_sessions')->truncate();

        $search_session = json_decode(file_get_contents(storage_path('search_sessions.json')));

        foreach($search_session as $choices)
        {
            $choice = new SearchSession;
            $choice->group_id = $choices->group_id;
            $choice->event_id = $choices->event_id;
            $choice->searched_date = $choices->searched_date;
            $choice->start_time = $choices->start_time;
            $choice->end_time = $choices->end_time;
            $choice->city = $choices->city;
            $choice->user_id = $choices->user_id;
            $choice->save();
        }
    }
}
