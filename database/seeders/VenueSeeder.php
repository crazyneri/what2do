<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

use DB;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venues')->truncate();

        $venues = json_decode(file_get_contents(storage_path('venues.json')));

        foreach($venues as $venue){
            $vne = new Venue;
            $vne->name = $venue->name;
            $vne->admin_id = $venue->admin_id;
            $vne->address = $venue->address;
            $vne->city = $venue->city;
            $vne->email = $venue->email;
            $vne->phone = $venue->phone;
            $vne->website = $venue->website;
            $vne->map_link = $venue->map_link;
            $vne->save();
        }
    }
}
