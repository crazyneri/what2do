<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SearchSession;
use App\Models\Event;
use App\Models\UserChoice;
use App\Models\Group;
use DB;

class SearchResultsController extends Controller
{
    //
   
    // ** matches categories to the available events
    public function getUserResults($set_of_choices, $possible_events)
    {
        // ** create an array of the categories
        
        $category_ids = [       
            $set_of_choices->category1_id,
            $set_of_choices->category2_id,
            $set_of_choices->category3_id,
            $set_of_choices->category4_id,
            $set_of_choices->category5_id,
            $set_of_choices->category6_id,
            $set_of_choices->category7_id,
            $set_of_choices->category8_id,
            $set_of_choices->category9_id,
        ];

        // ** create an array of obejects where the categories match
        // ** the available events
        // ** the scores will be given at the next step

        $events_match = [];

        foreach($category_ids as $choice_category)
        {
            foreach($possible_events as $event)
            {
                foreach($event->categories as $event_category)
                {
                    if($choice_category == $event_category->id)
                    {
                        $events_match[] = [
                            'event_id' => $event->id, 
                            'category_id' => $event_category->id, 
                            'score' => 0,
                        ];
                    }
                }
            }
        }

        // ** assign scores for each event based on the position in the choice list
        
        for($i = 0; $i < count($category_ids); $i++)
        {
            foreach($events_match as &$event)
            {      
                if($category_ids[$i] == $event['category_id'])
                {
                    $event['score'] += (9 - $i);
                }    
            }
        }

        // ** a bonus point is given for each second category the event matches
        // ** (the second match is then removed from the array)

        for($i = 0; $i < count($events_match); $i++)
        {
            for($j = $i+1; $j < count($events_match); $j++)
            {
                if($events_match[$i]['event_id'] == $events_match[$j]['event_id'])
                {
                    $events_match[$i]['score'] += 1;
                    array_splice($events_match, $j, 1);
                }
            }
        }

        return $events_match;
    }

    // ** for the usort
    public function bestMatch($a, $b)
    {
        if($a['score'] == $b['score']) 
        {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }

    // ** filters the possible events by date/day/time and retrieves the
    // ** relevant user choices 
    public function findMatch($session_id)
    {
        // ** find the search session and matching user_choice tables
        
        $search_session = SearchSession::findOrFail($session_id);

        // return $search_session;
        
        $user_choices = UserChoice::where('session_id', '=', $session_id)
                ->get(); // $user_choices is an array of individual results

        // ** filter the events by the time and date

        $possible_events_by_date_time = Event::with('categories')
                ->where('start_date', '<=', $search_session->searched_date)->where('end_date', '>=', $search_session->searched_date)
                ->where('start_time', '>=', $search_session->start_time)->where('end_time', '<=', $search_session->end_time)
                ->get();


        // return $possible_events_by_date_time;

        // ** filter days for repeated events hat occur on that day

        $day = strtolower(date('l', strtotime($search_session->searched_date)));
        
        $possible_events = [];

        foreach($possible_events_by_date_time as $event)
        {
          if($event->is_recurring == 0) {
                $possible_events[] = $event;
                continue;
          }  
          if($event->is_recurring == 1 && $event[$day] == 1)
            {
                $possible_events[] = $event;
            }
        }

        // return $possible_events;

        // ** match events to user category choices
        // ** each user has an array of their own events to be compared

        $user_category_choices = [];

        foreach($user_choices as $set_of_choices)
        {
            $user_category_choices[] = $this->getUserResults($set_of_choices, $possible_events);
        }


        // return $user_category_choices;

        // ** create new array to hold all of the choices and remove duplicates
        // ** the scores are added together and bonus points given for 
        // ** events in multiple arrays

        $group_choices = [];

        for($i = 0; $i < count($user_category_choices); $i++)
        {
            foreach($user_category_choices[$i] as $choice_i)
            {
                for($j = $i + 1; $j < count($user_category_choices); $j++)
                {
                    for($k = 0; $k < count($user_category_choices[$j]); $k++)
                    {
                        if($choice_i['event_id'] == $user_category_choices[$j][$k]['event_id'])
                        {
                            // return $user_category_choices[$j][$k];
                            $choice_i['score'] += $user_category_choices[$j][$k]['score'] + 2;
                            // ** remove the event so it doesn't get recounted
                            array_splice($user_category_choices[$j], $k, 1);
                            
                            $group_choices[] = $choice_i;
                        }
                    }
                }
            }
        }

        // ** put them in order so the highest score is first in the array

        usort($group_choices, array($this, 'bestMatch'));

        return $group_choices;

    }


    // !! uncomment the below to plug in with front end

    // // ** gets the request and gets/fills the tables to do the search

    // public function handleSearch(Request $request)
    // {
        
    //     // ** declare search session to use 
    //     // ** (remove if the search session is always included in teh request and
    //     // ** the if statements aren't required)

    //     $search_session = null;
        
    //     // ** Does the search_session already exist at this point?
    //     // ** If not, create the search session first and add the data
        
    //     if(empty($request->input('search_session_id')))
    //     {
    //         $search_session = new SearchSession();
    //         $search_session->group_id = $request->input('group_id');
    //         $search_session->searched_date = $request->input('searched_date');
    //         $search_session->start_time = $request->input('start_time');
    //         $search_session->end_time = $request->input('end_time');
    //         $search_session->city = $request->input('city');
    //         $search_session->user_id = $request->input('user_id');
    //         $search_session->save();
    //     }

    //     // ** If it does, get the session and add the relevant data from the form

    //     if(!empty($request->input('search_session_id')))
    //     {
    //         $search_session = SearchSession->findOrFail($request->input('search_session_id'));
    //         $search_session->searched_date = $request->input('searched_date');
    //         $search_session->start_time = $request->input('start_time');
    //         $search_session->end_time = $request->input('end_time');
    //         $search_session->city = $request->input('city');
    //         $search_session->user_id = $request->input('user_id');
    //         $search_session->save();
    //     }

    //    // ** create a new user choices

    //     $user_choices = new UserChoice();
    //     $user_choices->user_id = $request->input('user_id');
    //     $user_choices->session_id = $search_session->id;
    //     $user_choices->max_budget = $request->input('budget');
    //     $user_choices->category1_id = $request->input('searchIds'[0]);
    //     $user_choices->category2_id = $request->input('searchIds'[1]);
    //     $user_choices->category3_id = $request->input('searchIds'[2]);
    //     $user_choices->category4_id = $request->input('searchIds'[3]);
    //     $user_choices->category5_id = $request->input('searchIds'[4]);
    //     $user_choices->category6_id = $request->input('searchIds'[5]);
    //     $user_choices->category7_id = $request->input('searchIds'[6]);
    //     $user_choices->category8_id = $request->input('searchIds'[7]);
    //     $user_choices->category9_id = $request->input('searchIds'[8]);
    //     $user_choices->save();

        // ** find out how many people are in the group

    // !! test function only as cannot get the request to test yet
    public function test($session_id, $user_choices_id)
    {

        $search_session = SearchSession::findOrFail($session_id);
        $user_choices = UserChoice::findOrFail($user_choices_id);

        $group_info = Group::with('users')
                ->where('id', '=', $search_session->group_id)
                ->get();

        $group_info = $group_info[0]->users;
        
        $group_number = count($group_info);

        // ** find out how many people have completed this session
        // ** HOW?!

        $user_info = UserChoice::where('session_id', '=', $session_id)
                ->get();
        $users_completed_number = count($user_info);
       
        
        // ** If the numbers are the same, run the search.
        // ** If the user is the first (i.e. they set up the search),
        // ** send the others a notifcation to complete their choices. 
        // ** If neither of the above, return a message to say we are waiting for other 
        // ** group members.

        if($users_completed_number < $group_number)
        {
            if($users_completed_number == 1)
            {
                // ** Find other group members and send their info to 
                // ** the notications controller

                $other_group_members = [];

                for($i = 0; $i < count($group_info); $i++)
                {
                    if($user_choices->user_id != $group_info[$i]['id'])
                    {
                        $other_group_members[] = $group_info[$i];
                    }
                }

                return action(NotifyController::Class, 'notify', ['id' => $other_group_members]);
                return 'You seem lonely!';// email and notify the other group members
            }
            return "Thank you for your choices, when everyone has completed the search we'll let you know!";
        }

        if($users_completed_number = $group_number)
        {
                  
            $group_choices = $this->findMatch($search_session->id);

            // ** get winning event

            $event = Event::findOrFail($group_choices[0]['event_id']);

            // ** add event to search session
            $search_session->event_id = $group_choices[0]['event_id'];
            $search_session->save();
    
            return view('search\result', compact('group_choices', 'event'));
        }

    }
}

// ** original single search - filtering by user choices and date first!!
// ** open at your own risk!

//  public function singleSearch($id)
//    {
        // ** id needs to be user_choices id **
//        $user_choices = UserChoice::findOrFail($id);
//        $search_session = SearchSession::findOrFail($user_choices->session_id);
        // $search_session = $user_choices->session;

        //     $search_session = new SearchSession();
        //     $search_session->id = 1;
        //     $search_session->group_id = 1;
        //     // $search_session->foreignId('event_id');
        //     $search_session->start = '17:00:00';
        //     $search_session->end = null;
        //     $search_session->searched_date = '2021-11-27';
        //     $search_session->city = 'Prague';
        //    // $search_session->foreignId('user_id')->nullable();


        // $user_choices = new UserChoice();
        //     $user_choices->id = 1;
        //     $user_choices->user_id = 1;
        //     $user_choices->session_id = 1;
        //     $user_choices->max_budget = 2000;
        //     $user_choices->category1 = 4;
        //     $user_choices->category2 = 28;
        //     $user_choices->category3 = 31;
        //     $user_choices->category4 = 34;
        //     $user_choices->category5 = 12;
        //     $user_choices->category6 = 17;
        //     $user_choices->category7 = 33;
        //     $user_choices->category8 = 7;
        //     $user_choices->category9 = 19;
        
  
        // $user_choices_array = [       
        //     $user_choices->category1_id,
        //     $user_choices->category2_id,
        //     $user_choices->category3_id,
        //     $user_choices->category4_id,
        //     $user_choices->category5_id,
        //     $user_choices->category6_id,
        //     $user_choices->category7_id,
        //     $user_choices->category8_id,
        //     $user_choices->category9_id,
        // ];


        //    $date = '2021-11-27';
        
        // ** to do - 
        // ** - when events are repeated we will neeed to search for a range 
        // **   and then process that range for the day of the week
        // ** - filter by budget (also needs an input)

    //     $date_range = null;

    //     foreach($user_choices_array as $value)
    //     {
    //             if($value)
    //             {
    //             $date_range[] = Category::with([
    //                 'events' => function($query) use ($search_session) {
    //                 $query->where('start_date', '<=', $search_session->searched_date)->where('end_date', '>=', $search_session->searched_date);
                
    //             //    $query->where('start_date', '=', $search_session->searched_date);
                    
    //                 }
    //             ]
    //             )
    //             ->where('id', $value)
    //             ->get();
    //             }
    //     }

    //     // return $date_range;
        
    //     $events_match = null;
        
    //     foreach($date_range as $value)
    //     {
    //         foreach($value as $category)
    //         {
    //             if($category->events != '[]')
    //             {
    //                 $events_match[] = $category->events;
    //             }     
    //         }
    //     }
               

    //     //  return $events_match;


    //     // check for start time
      
    //     $right_time_of_day = null;
      
    //     foreach($events_match as $possible_event)
    //     {
    //       foreach($possible_event as $event)
    //       {
    //           if(strtotime($search_session->start) <= strtotime($event->start_time))
    //           {
    //               if($search_session->end != null)
    //               { 
    //                   if(strtotime($search_session->end) >= strtotime($event->end_time))
    //                   {
    //                       $right_time_of_day[] = $event;
    //                       continue;
    //                     } else {
    //                         continue;
    //                     }
    //                 }
    //                 $right_time_of_day[] = $event;
    //             }
    //         }
    //     }

    //     // check for day match
        
    //     $day = strtolower(date('l', strtotime($search_session->searched_date)));
        
        
    //     $right_day = [];

    //     foreach($right_time_of_day as $event)
    //     {
    //       if($event->is_recurring == 0) {
    //           $right_day[] = $event;
    //           continue;
    //       }  
    //       if($event->is_recurring == 1 && $event[$day] == 1)
    //         {
    //           $right_day[] = $event;
    //         }
    //     }
    //     //return $day;
    //     //  return $right_day;

    //      // create a list of user events and assign a score based on preferences

    //     $final_choices = null;
    //     foreach($right_day as $key => $value) {
    //           $final_choices[] = [ 
    //               'event_id' => $value->id, 
    //               'category_id' => $value->pivot->category_id, 
    //               'score' => 0,
    //               'start_time' => strtotime($value->start_time)
    //            ];
    //     }


    //     for($i = 0; $i < count($user_choices_array); $i++)
    //     {
    //           foreach($final_choices as &$event)
    //           {      
    //               if($user_choices_array[$i] == $event['category_id'])
    //               {
    //                   $event['score'] += (9 - $i);
    //                   //  var_dump($event['event_id'] . '-score: ' . $event['score']);
    //               }    
    //           }
    //     }
        
    //     for($i = 0; $i < count($final_choices); $i++)
    //     {
    //           for($j = $i+1; $j < count($final_choices); $j++)
    //               {
    //                   if($final_choices[$i]['event_id'] == $final_choices[$j]['event_id'])
    //                   {
    //                       $final_choices[$i]['score'] += 1;
    //                       array_splice($final_choices, $j, 1);
    //                   }
    //               }
    //     }
        
    //     // create a searchable set of values

    //     $user_results = [
    //               'user_id' => $user_choices->user_id,
    //               'search_session' => $search_session->id,
    //               'group_id' => $search_session->group_id,
    //               'results' => $final_choices,
    //       ];

    //     return $user_results;
        
    // }
