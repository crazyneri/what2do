<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\CategoryEvent;

use DB;
class CategoryEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_event')->truncate();

        $category_events = json_decode(file_get_contents(storage_path('category_event.json')));

        foreach($category_events as $category_event){
            DB::table('category_event')->insert([
                'category_id' => $category_event->category_id,
                'event_id' => $category_event->event_id
            ]);
        }
    }
}
