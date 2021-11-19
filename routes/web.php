<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use App\Notifications\InvoicePaid;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// HOME PAGE
Route::get('/', function () {
    return view('home/index');
});

// ADMIN PART
Route::group(["middleware" => "can:admin"], function() {
    // admin - main page
    Route::get('/admin', 'AdminController@show');
    
    // admin - create and display events
    Route::get('/admin/events', 'EventController@index');
    Route::view('/admin/event/create', 'event/form');
    Route::get('/admin/event/data', 'EventController@data');
    Route::post('/admin/event/store', 'EventController@store');

    // admin - dipslay/create new venue
    Route::get('/admin/venue/create', 'VenueController@create');
    Route::post('/admin/venue/create', 'VenueController@store');
    Route::post('/admin/venue/create', 'VenueController@store');
    Route::get('/admin/venue/{id}/edit', 'VenueController@edit');
    Route::get('/admin/venue/{id}', 'VenueController@show');
    Route::put('/admin/venue/{id}', 'VenueController@update');
});

// SEARCH PART
Route::get('/search', 'SearchController@index');

// USER PART
Route::get('/users','UserController@index');
Route::get('/user/{id}', 'UserController@show');
Route::get('/user/{id}/edit', 'UserController@edit');
Route::post('/user/{id}', 'UserController@update');
Route::post('/user/{id}/group', 'UserController@createGroup');
Route::get('/user/{id}/add', 'UserController@addFriend');

// add user to group
Route::post('/group/{id}','UserController@groupAddUser');

// EMAIL PART
// registration - CHANGE SENDING EMAIL AFTER THE REGISTRATION
Route::get('/send-email', function(){
    Mail::to('user@email.com')->send(new TestEmail());
});

// notification - GROUP and USERS NEEDS TO BE ADDED
Route::get('/send-notification', function(){
    $user = User::where('name', 'Jachym Pivonka')->first();

    $user->notify(new InvoicePaid);
});
// dummy search
Route::get('/solo_search', 'SearchResultsController@soloSearch');
