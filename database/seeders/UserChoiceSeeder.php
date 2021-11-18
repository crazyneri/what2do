<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserChoice;

use DB;

class UserChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('user_choices')->truncate();

        $user_choices = json_decode(file_get_contents(storage_path('user_choices.json')));

        foreach($user_choices as $choices)
        {
            $choice = new UserChoice;
            $choice->user_id = $choices->user_id;
            $choice->session_id = $choices->session_id;
            $choice->max_budget = $choices->max_budget;
            $choice->category1_id = $choices->category1_id;
            $choice->category2_id = $choices->category2_id;
            $choice->category3_id = $choices->category3_id;
            $choice->category4_id = $choices->category4_id;
            $choice->category5_id = $choices->category5_id;
            $choice->category6_id = $choices->category6_id;
            $choice->category7_id = $choices->category7_id;
            $choice->category8_id = $choices->category8_id;
            $choice->category9_id = $choices->category9_id;
            $choice->save();
        }
    }
}
