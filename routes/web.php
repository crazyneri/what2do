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
Route::get('/admin', 'AdminController@show');

// VENUE PART
Route::get('/venue/{id}', 'VenueController@show');
Route::get('/admin/venue/create', 'VenueController@create');
Route::post('/admin/venue/create', 'VenueController@store');
Route::post('/venue/create', 'VenueController@store');
Route::get('/venue/{id}/edit', 'VenueController@edit');
Route::put('/venue/{id}', 'VenueController@update');

// SEARCH PART
Route::get('/search', 'SearchController@index');






// USER PART
// can be limited by Auth
// no id -> Auth::id instead in Controllers
Route::get('/users','UserController@index');
Route::get('/user/{id}', 'UserController@show')->middleware('auth');
Route::get('/user/{id}/edit', 'UserController@edit')->middleware('auth');
Route::post('/user/{id}', 'UserController@update')->middleware('auth');
Route::get('/user/{id}/group', 'UserController@createGroup')->middleware('auth');
Route::post('/user/{id}/group', 'UserController@createGroup')->middleware('auth');
// add user to group
Route::get('/group/{id}','UserController@showGroup')->middleware('auth');
Route::post('/group/{id}','UserController@groupAddUser')->middleware('auth');
Route::get('/group/{id}/user/{user_id}', 'UserController@removeFriend');
Route::delete('/group/{id}/user/{user_id}', 'UserController@removeFriend');




// EVENT PART
Route::get('/admin/events', 'EventController@index');
Route::view('/admin/event/create', 'event/form');
Route::get('/admin/event/data', 'EventController@data');
Route::post('/admin/event/data', 'EventController@store');


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
