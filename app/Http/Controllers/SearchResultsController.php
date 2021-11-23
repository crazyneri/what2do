<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use App\Models\SearchSession;
use App\Models\UserChoice;
use App\Notifications\InvoicePaid;
use Notification;

class SearchResultsController extends Controller
{
    //

    // ** matches categories to the available events
    public function show($user_id)
    {
        $user_info = User::findOrFail($user_id);
        $user_sessions = [];
        foreach($user_info->user_choices as $choice)
        {
            $user_sessions[] = SearchSession::find($choice->session_id);
        }

        $user_choices = [];
foreach($user_sessions as $session)
{
    $user_choices[] = $session->user_choices;
}
// $users = [];
// foreach($user_choices as $set)
// {
// $users[] = User::find($set->user_id);
// }
        // $user_session_info = User::with(['user_choices', 'user_choices.search_sessions', 'user_choices.search_sessions.group'])
        //     ->where('id', $user_id)
        //     ->get();
        // $user_sessions = $user_session_info[0];
        return $user_choices[0][0]->user;
        
        return $user_sessions;
        return $user_info->user_choices;
        return view('search.sessions', compact('user_sessions'));
        return 'bollocks';
    }

}   