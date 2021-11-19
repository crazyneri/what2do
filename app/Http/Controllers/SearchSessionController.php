<?php

namespace App\Http\Controllers;

class SearchSessionController extends Controller
{
    public function store()
    {$sessionData = [
        'user_id' => $request->input('user_id'),
        'group_id' => $request->input('group_id'),
    ];

        return $sessionData;
    }
}
