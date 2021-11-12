<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

use Auth;

class VenueController extends Controller
{
    
    // CREATE FORM
    public function create(){

        return view('venue/form');
    }

    // STORE DATA TO THE DATABASE
    public function store(Request $request) {

        $data = $request->all();
        $data['admin_id'] = Auth::user()->id;

        Venue::create($data);

        session()->flash('success_message', 'The venue has been created!');

        return redirect()->action('AdminController@show');
    }

    // SHOW DETAIL ABOUT VENUE
    public function show($id) {
        
        $venue = Venue::findOrFail($id);

        return view('venue/show', compact('venue'));
 
    }

    
}
