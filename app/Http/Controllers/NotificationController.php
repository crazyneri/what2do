<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\InvoicePaid;

class NotificationController extends Controller
{
    public function notify($id)
    {

    dd($id);

    $user = User::where('name', 'Jachym Pivonka')->first();

    $user->notify(new InvoicePaid);
    }
}
