<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SearchSession;
use App\Models\Event;
use App\Models\UserChoice;
use DB;

class SearchResultsController extends Controller
{
    //
    public function soloSearch()
    {
            $search_session = new SearchSession();
            $search_session->id = 1;
            $search_session->group_id = 1;
            // $search_session->foreignId('event_id');
            $search_session->when = 'evening';
            $search_session->searched_date = '2021-11-27';
            $search_session->city = 'Prague';
           // $search_session->foreignId('user_id')->nullable();


        $user_choices = new UserChoice();
            $user_choices->id = 1;
            $user_choices->user_id = 1;
            $user_choices->session_id = 1;
            $user_choices->max_budget = 2000;
            $user_choices->category1 = 4;
            $user_choices->category2 = 28;
            $user_choices->category3 = 31;
            $user_choices->category4 = 34;
            $user_choices->category5 = 12;
            $user_choices->category6 = 17;
            $user_choices->category7 = 33;
            $user_choices->category8 = 7;
            $user_choices->category9 = 19;
        
  
        $user_choices_array = [       
            $user_choices->category1,
            $user_choices->category2,
            $user_choices->category3,
            $user_choices->category4,
            $user_choices->category5,
            $user_choices->category6,
            $user_choices->category7,
            $user_choices->category8,
            $user_choices->category9,
        ];


        $date = '2021-11-27';
    

        $category_match = null;

        foreach($user_choices_array as $value)
        {
                if($value)
                {
                $category_match[] = Category::with([
                    'events' => function($query) use ($search_session) {
                    
                    $query->whereDate('start_date', '=', $search_session->searched_date);
                    
                    }
                ]
                )
                ->where('id', $value)
                ->get();
            }
        }

       // return $category_match;

        // get only those categories with events today
        
        $events_match = null;
        
        foreach($category_match as $value)
        {
            foreach($value as $category)
            {
                if($category->events != '[]')
                {
                    $events_match[] = $category->events;
                }     
            }
        }

     //   return $events_match;
        // get start time

        $start_after = null;

        if($search_session->when == "morning")
        {
            $start_after = '06:00:00';
        }
        if($search_session->when == "afternoon")
        {
            $start_after = '12:00:00';
        }
        if($search_session->when == "evening")
        {
            $start_after = '17:00:00';
        }
        
               

        // check for start time

        $right_time_of_day = null;
        
        foreach($events_match as $possible_event)
        {
            foreach($possible_event as $event)
            {
                if(strtotime($start_after) <= strtotime($event->start_time))
                {
                     $right_time_of_day[] = $event;
                }
            }
        }

        return $right_time_of_day;



       




        return view('search\result');
    }

        public function groupSearch()
    {
        return view('search\result');
    }
}
