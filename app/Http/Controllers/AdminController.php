<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // pluck display all values for selected element -> all venue ids for current user
        $events = Event::orderBy('start_date', 'ASC')
                        ->whereIn('venue_id', $venues->pluck('id'))
                        ->limit(5)
                        ->get();

        return view('admin/index', compact('user', 'events', 'venues'));
    }

}
