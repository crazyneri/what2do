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
                    $query->orderBy('start_date')->whereDate('start_date', '>=', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();
        
        // get all user's venues with events as an array and sort events by date - HISTORY
        $venues_hist = Venue::with([
                'events' => function($query) {
                    $query->orderBy('start_date')->whereDate('start_date', '<', date('Y-m-d'));
                }
                ]

                )
                        ->where('admin_id', $user)
                        ->get();

        return view('event/index', compact('venues', 'venues_hist'));
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

        Event::create($data->input);

        return $request->all();
    }
}