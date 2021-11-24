<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SearchSession;

class SearchSessionController extends Controller
{
    //
    public function getSearchSessionDetails()
    {

        $search_session_id = session('session_id');

        if (isset($search_session_id)) {

            $search_session = SearchSession::findOrFail($search_session_id);

            $search_session->load(['user_choices', 'group', 'group.users']);

            if (isset($search_session->event_id)) {
                $search_session->load(['event', 'event.venue']);
            }

            return $search_session;

            // $data = [
            //     'session_id' => $search_session->id,
            //     'group_id' => $search_session->group_id,
            //     'user_choices' => $search_session->user_choices,
            // ];
        } else {
            $data = [
                'id' => 0,
                'group_id' => 0,
            ];

        }

        return $data;
    }

}
