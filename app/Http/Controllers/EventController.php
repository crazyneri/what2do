<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use Auth;

class EventController extends Controller
{
    public function index(){
        
        // get user id
        $user = Auth::user();

        $venues = $user->venues;

        $user->events;

        // get all users venues with events as an array and sort events by date
        $venues = Venue::with([
                'events' => function($query) {
                    $query->orderBy('start_date');
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();

        return $user;
    }

    // WILL BE DONE IN REACT
    // CREATE FORM
    public function create(){

        $user = Auth::user();

        $venues = $user->venues;

        return view('event/form', compact('venues'));
    }

    // STORE EVENT TO THE DB
    public function store(Request $request){

        $data = $request->all();
        $data['is_recurring'] = 0;

        // dd($data);
        
        Event::create($data);

        session()->flash('success_message', 'The event has been created!');

        return redirect()->action('AdminController@show');
    }
}
