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
            $search_session->start = '17:00:00';
            $search_session->end = null;
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


    //    $date = '2021-11-27';
    
// ** to do - when events are repeated we will neeed to search for a range and then process that range for
// ** the day of the week

        $date_range = null;

        foreach($user_choices_array as $value)
        {
                if($value)
                {
                $date_range[] = Category::with([
                    'events' => function($query) use ($search_session) {
                //    $query->where('start_date', '<=', $search_session->searched_date)->where('start_date', '=>', $search_session->searched_date);
                
                    $query->where('start_date', '=', $search_session->searched_date);
                    
                    }
                ]
                )
                ->where('id', $value)
                ->get();
            }
        }

//     return $date_range;

        // 
        
        $events_match = null;
        
        foreach($date_range as $value)
        {
            foreach($value as $category)
            {
                if($category->events != '[]')
                {
                    $events_match[] = $category->events;
                }     
            }
        }

 //       return $events_match;
        // // get start time

        // $start_after = null;

        // if($search_session->when == "morning")
        // {
        //     $start_after = '06:00:00';
        // }
        // if($search_session->when == "afternoon")
        // {
        //     $start_after = '12:00:00';
        // }
        // if($search_session->when == "evening")
        // {
        //     $start_after = '17:00:00';
        // }
        
               

        // check for start time

        $right_time_of_day = null;
        
        foreach($events_match as $possible_event)
        {
            foreach($possible_event as $event)
            {
                if(strtotime($search_session->start) <= strtotime($event->start_time))
                {
                    if($search_session->end != null)
                    { 
                        if(strtotime($search_session->end) >= strtotime($event->end_time))
                        {
                            $right_time_of_day[] = $event;
                            continue;
                        } else {
                            continue;
                        }
                    }
                $right_time_of_day[] = $event;
                }
            }
        }

      //  asort($right_time_of_day->start_time);

       // return $right_time_of_day;


       // create a list of user events and assign a score based on preferences

        $final_choices = null;
        foreach($right_time_of_day as $key => $value) {
            $final_choices[] = [ 
                'event_id' => $value->id, 
                'category_id' => $value->pivot->category_id, 
                'score' => 0,
                'start_time' => strtotime($value->start_time)
             ];
        }


        for($i = 0; $i < count($user_choices_array); $i++)
        {
            foreach($final_choices as &$event)
            {      
                if($user_choices_array[$i] == $event['category_id'])
                {
                    $event['score'] += (9 - $i);
                    //  var_dump($event['event_id'] . '-score: ' . $event['score']);
                }    
            }
        }
      
        for($i = 0; $i < count($final_choices); $i++)
        {
            for($j = $i+1; $j < count($final_choices); $j++)
                {
                    if($final_choices[$i]['event_id'] == $final_choices[$j]['event_id'])
                    {
                        $final_choices[$i]['score'] += 1;
                        array_splice($final_choices, $j, 1);
                    }
                }
        }
       

        
return $final_choices;

        // foreach($final_choices as $check_duplicate)
        // {
        //     foreach($final_choices as &$event)
        //     {
        //         if($check_duplicate['event_id'] == $event['event_id'])
        //         {
        //             $event['score'] += $check_duplicate['score']/2;
        //         }

        //     }
        // }

        //return 'bollocks';
     return $final_choices;



       




        return view('search\result');
    }

        public function groupSearch()
    {
        return view('search\result');
    }
    public function handle_search()
    {
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
    }
}
