<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SearchSession;

class SearchSessionController extends Controller
{
    //
    public function getSearchSessionDetails()
    {

        $search_session_id = session('search_session_id');

        if (isset($search_session_id)) {

            $search_session = SearchSession::findOrFail($search_session_id);

            $data = [
                'search_session_id' => $search_session->id,
                'group_id' => $search_session->group_id,
            ];
        } else {
            $data = [
                'search_session_id' => 0,
                'group_id' => 0,
            ];

        }

        return $data;
    }

}
