<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\SearchSession;
use App\Models\UserChoice;
use Illuminate\Http\Request;

class UserChoiceController extends Controller
{
    public function store(Request $request)
    {
        $userChoicesData = [
            'session_id' => $request->input('session_id'),
            'user_id' => $request->input('user_id'),
        ];

        $category_ids = $request->input('category_ids');

        foreach ($category_ids as $i => $id) {

            $index = $i + 1;

            $string = "category{$index}_id";

            $userChoicesData[$string] = $id;
        };

        $session_id = $request->input('session_id');

        $user_choice = UserChoice::create($userChoicesData);

        $user_choices_id = $user_choice->id;

        return $this->handleSearch($session_id, $user_choices_id);
    }

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

        foreach ($category_ids as $choice_category) {
            foreach ($possible_events as $event) {
                foreach ($event->categories as $event_category) {
                    if ($choice_category == $event_category->id) {
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

        for ($i = 0; $i < count($category_ids); $i++) {
            foreach ($events_match as &$event) {
                if ($category_ids[$i] == $event['category_id']) {
                    $event['score'] += (9 - $i);
                }
            }
        }

        // ** a bonus point is given for each second category the event matches
        // ** (the second match is then removed from the array)

        for ($i = 0; $i < count($events_match); $i++) {
            for ($j = $i + 1; $j < count($events_match); $j++) {
                if ($events_match[$i]['event_id'] == $events_match[$j]['event_id']) {
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
        if ($a['score'] == $b['score']) {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }

    // ** filters the possible events by date/day/time and retrieves the
    // ** relevant user choices
    public function findMatch($session_id, $users_completed_number)
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

        foreach ($possible_events_by_date_time as $event) {
            if ($event->is_recurring == 0) {
                $possible_events[] = $event;
                continue;
            }
            if ($event->is_recurring == 1 && $event[$day] == 1) {
                $possible_events[] = $event;
            }
        }

        // return $possible_events;

        // ** match events to user category choices
        // ** each user has an array of their own events to be compared

        $user_category_choices = [];

        foreach ($user_choices as $set_of_choices) {
            $user_category_choices[] = $this->getUserResults($set_of_choices, $possible_events);
        }

        // return $user_category_choices;

        // ** create new array to hold all of the choices and remove duplicates
        // ** the scores are added together and bonus points given for
        // ** events in multiple arrays

        $group_choices = [];

        
        if($users_completed_number > 1)
        {
            for ($i = 0; $i < count($user_category_choices); $i++) {
                foreach ($user_category_choices[$i] as $choice_i) {
                    for ($j = $i + 1; $j < count($user_category_choices); $j++) {
                        for ($k = 0; $k < count($user_category_choices[$j]); $k++) {
                            if ($choice_i['event_id'] == $user_category_choices[$j][$k]['event_id']) {
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
        }

        if($users_completed_number == 1)
        {
            $group_choices = $user_category_choices[0];
        }

        // ** put them in order so the highest score is first in the array

        usort($group_choices, array($this, 'bestMatch'));

        return $group_choices;

    }

    public function handleSearch($session_id, $user_choices_id)
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

        if ($users_completed_number < $group_number) {
            if ($users_completed_number == 1) {
                // ** Find other group members and send their info to
                // ** the notications controller

                $other_group_members = [];

                for ($i = 0; $i < count($group_info); $i++) {
                    if ($user_choices->user_id != $group_info[$i]['id']) {
                        $other_group_members[] = $group_info[$i];
                    }
                }

                // return action(NotifyController::Class, 'notify', ['id' => $other_group_members]);
                return 'You seem lonely!'; // email and notify the other group members
            }
            return "Thank you for your choices, when everyone has completed the search we'll let you know!";
        }

        if ($users_completed_number == $group_number) {
            // return $this->findMatch($search_session->id, $users_completed_number);
            $group_choices = $this->findMatch($search_session->id, $users_completed_number);
            
            // ** get winning event
            $event = Event::findOrFail($group_choices[0]['event_id']);
            // ** add event to search session
            $search_session->event_id = $group_choices[0]['event_id'];
            $search_session->save();

            return ['url' => "/session_search/{$search_session->id}"];
            // return view('search\result', compact('group_choices', 'event'));
            // if(!empty($group_choices[0]['event_id']))
            // {
            // }
            // return "Ooops, maybe try to be less fussy!";
        }
    }

}
