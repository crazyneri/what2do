<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;

use Auth;

class VenueController extends Controller
{
    
    // CREATE FORM
    public function create(){

        $venue = new Venue;

        return view('venue/create', compact('venue'));
    }

    // STORE DATA TO THE DATABASE
    public function store(Request $request) {

        $data = $request->all();
        $data['admin_id'] = Auth::user()->id;

        $this->venueValidate($request);

        Venue::create($data);

        session()->flash('success_message', 'The venue has been created!');

        return redirect()->action('AdminController@show');
    }

    // SHOW DETAIL ABOUT VENUE AND EVENTS
    public function show($id) {
        
        $venue = Venue::findOrFail($id);

        $currentDate = date('Y-m-d');

        $events = Event::orderBy('start_date', 'ASC')
                        ->where('venue_id', $id)
                        ->whereDate('start_date', '>=', $currentDate)
                        ->get();

        return view('venue/show', compact('venue', 'events'));
 
    }

    // EDIT CURRENT VENUE
    public function edit($id){
        
        $venue = Venue::findOrFail($id);

        return view('venue/form', compact('venue'));
    }

    // UPDATE CURRENT VENUE
    public function update(Request $request, $id){
        
        $venue = Venue::findOrFail($id);

        $data = $request->all();
        

        $this->venueValidate($request);

        $venue->update($data);

        session()->flash('success_message', 'The venue has been updated!');

        return redirect()->action('VenueController@show', ['id' => $id]);

    }

    // VALIDATION FOR VENUE FORM
    public function venueValidate(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3',
            'website' => 'url',
            'map_link' => 'url',
        ], [
            'name.required' => 'Did you forget to fill venue name?',
            'name.min' => 'Name of your venue is too short.',
            'website.url' => 'Your website is not proper URL.',
            'map_link.url' => 'Your map link is not proper URL.'
        ]);
    }

    
}
