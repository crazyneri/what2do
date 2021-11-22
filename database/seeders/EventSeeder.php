<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

use DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->truncate();

        $events = json_decode(file_get_contents(storage_path('events.json')));

        foreach($events as $event){
            $evn = new Event;
            $evn->venue_id = $event->venue_id;
            $evn->name = $event->name;
            $evn->start_date = $event->start_date;
            $evn->start_time = $event->start_time;
            $evn->end_date = $event->end_date;
            $evn->end_time = $event->end_time;
            $evn->description = $event->description;
            $evn->price = $event->price;
            $evn->is_recurring = $event->is_recurring;
            if($event->is_recurring == 1){
                $evn->monday = $event->monday;
                $evn->tuesday = $event->tuesday;
                $evn->wednesday = $event->wednesday;
                $evn->thursday = $event->thursday;
                $evn->friday = $event->friday;
                $evn->saturday = $event->saturday;
                $evn->sunday = $event->sunday;
            }
            
            $evn->save();
        }
    }
}
