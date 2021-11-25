<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use Auth;

class AdminController extends Controller
{

    // SHOW VENUES AND COMMING SOON EVENT OF LOGGED USER
    public function show(){

        // get logged user
        $user = Auth::user();

        // get venues that bellongs to the user (hasManyThrough relationship in User model). Same as:
        //$venues = Venue::where('admin_id', $user->id)->get();
        $venues = $user->venues;

        // get current date
        $currentDate = date('Y-m-d');

        // get first 5 events depending on current date
        // pluck display all values for selected element -> all venue ids for current user
        $events = Event::orderBy('start_date', 'ASC')
                        ->whereIn('venue_id', $venues->pluck('id'))
                        ->whereDate('start_date', '>=', $currentDate)
                        ->limit(5)
                        ->get();

        // get events of venue to be able to calculate count of future events
        $venues_events = Venue::with([
                'events' => function($query) {
                    $query->whereDate('start_date', '>=', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user->id)
                        ->get();

        
        return view('admin/index', compact('events', 'venues_events'));
    }

}
