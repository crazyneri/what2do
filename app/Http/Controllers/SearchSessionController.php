<?php

namespace App\Http\Controllers;

use App\Models\SearchSession;
use Illuminate\Http\Request;

class SearchSessionController extends Controller
{
    public function store(Request $request)
    {
        $sessionData = [
            'user_id' => $request->input('user_id'),
            'group_id' => $request->input('group_id'),
        ];

        $search_session = SearchSession::create($sessionData);

        $search_session_id = $search_session->id;

        session(['session_id' => $search_session_id]);

        return $search_session_id;
    }
    public function update(Request $request)
    {

        $search_session_id = $request->input('session_id');

        $search_session = SearchSession::findOrFail($search_session_id);

        $search_session->city = $request->input('city');
        $search_session->searched_date = $request->input('searched_date');
        $search_session->start_time = $request->input('start_time');
        $search_session->end_time = $request->input('end_time');

        $search_session->save();

        return $search_session;
    }

    public function saveSessionToCookies(Request $request)
    {
        $search_session_id = $request->input('session_id');

        session(['session_id' => $search_session_id]);

        return $search_session_id;

    }
}
