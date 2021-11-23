<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\SearchSession;
use App\Models\UserChoice;
use App\Notifications\InvoicePaid;
use Notification;

class SearchResultsController extends Controller
{
    //

    // ** matches categories to the available events
    public function show($session_id)
    {
        $search_session = SearchSession::with('user_choices')
            ->where('id', $session_id)
            ->get();

        return $search_session;
        return 'bollocks';
    }

}   