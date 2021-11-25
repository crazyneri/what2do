<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function redirect()
    {
        $user = Auth::check();
        
        if($user){
            return redirect('/search');
        } else {
            return view('auth/login');
        }
        
    }
}
