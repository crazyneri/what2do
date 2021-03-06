<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use Auth;

class EventController extends Controller
{
    // DISPLAY ALL EVENTS SORTED IN VENUES TABLES
    public function index(){
        
        // get user id
        $user = Auth::user()->id;

        // get all user's venues with events as an array and sort events by date - FUTURE
        $venues = Venue::with([
                'events' => function($query) {
                    $query->orderBy('start_date')
                            ->where('is_recurring', 0)
                            ->whereDate('start_date', '>=', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();
        
        // get all user's venues with events as an array and sort events by date - HISTORY
        $venues_hist = Venue::with([
                'events' => function($query) {
                    $query->orderBy('start_date')
                            ->whereDate('start_date', '<', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();
        
        // get all user's venues with events as an array and sort events by date - REPEATED
        $venues_repeat = Venue::with([
                'events' => function($query) {
                    $query->where('is_recurring', 1)
                            ->whereDate('start_date', '>=', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();
        
        // return $venues_repeat;

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return view('event/index', compact('venues', 'venues_hist', 'venues_repeat', 'days'));
    }

    // CREATE A DATA FOR EVENT-CREATE FORM
    public function data(){

        $venues = Venue::where('admin_id', Auth::user()->id)->get();

        $categories = Category::all();

        return compact('venues', 'categories');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $this->eventValidate($request);
        
        $event = Event::create($data);
        
        // save data to the pivot table
        $event->categories()->sync($data['categories']);
        
        session()->flash('success_message', 'The event has been created!');

    }

    public function displayForm($id){
        
        return view('event/form', compact('id'));
    }

    public function getEvent($id){

        $event = Event::with('categories')->where('id', $id)->first();
        
        return $event;
    }

    public function updateEvent(Request $request, $id){

        $event = Event::findOrFail($id);
        $data = $request->all();

        $this->eventValidate($request);

        $event->update($data);

        // save data to the pivot table
        $event->categories()->sync($data['categories']);

        session()->flash('success_message', 'The event has been updated!');
    }

    // DELETE EVENT
    public function deleteEvent($id) {
        
        $event = Event::findOrFail($id);

        $event->categories()->detach();
        $event->delete();

        session()->flash('success_message', 'The event has been deleted!');

        return redirect()->action('EventController@index');
    }


     // VALIDATION FOR EVENT FORM
    public function eventValidate(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3',
            'venue_id' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'price' => 'required',
        ]);
    }
}
