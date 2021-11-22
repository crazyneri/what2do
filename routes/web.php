<?php

use App\Mail\TestEmail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    
    // admin - create/edit/display events
    Route::get('/admin/events', 'EventController@index');
    Route::view('/admin/event/create', 'event/form');
    Route::get('/admin/event/data', 'EventController@data');
    Route::post('/admin/event/store', 'EventController@store');
    Route::get('/admin/event/{id}', 'EventController@displayForm');
    Route::get('/admin/event/{id}/edit', 'EventController@getEvent');
    Route::put('/admin/event/{id}/update', 'EventController@updateEvent');
    Route::delete('/admin/event/{id}', 'EventController@deleteEvent');

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
// can be limited by Auth
// no id -> Auth::id instead in Controllers
Route::get('/users', 'UserController@index');
Route::get('/user/{id}', 'UserController@show')->middleware('auth');
Route::get('/user/{id}/edit', 'UserController@edit')->middleware('auth');
Route::post('/user/{id}', 'UserController@update')->middleware('auth');
Route::get('/user/{id}/group', 'UserController@createGroup')->middleware('auth');
Route::post('/user/{id}/group', 'UserController@createGroup')->middleware('auth');

// add user to group
Route::get('/group/{id}', 'UserController@showGroup')->middleware('auth');
Route::post('/group/{id}', 'UserController@groupAddUser')->middleware('auth');
Route::get('/group/{id}/user/{user_id}', 'UserController@removeFriend');
Route::delete('/group/{id}/user/{user_id}', 'UserController@removeFriend');

Route::post('/group/{id}','UserController@groupAddUser');

// registration - CHANGE SENDING EMAIL AFTER THE REGISTRATION
Route::get('/send-email', function () {
    Mail::to('user@email.com')->send(new TestEmail());
});

// notification - GROUP and USERS NEEDS TO BE ADDED
Route::get('/send-notification', 'NotificationController@notify');
// dummy search

// test search function
// Route::get('/solo_search/{id}', 'SearchResultsController@singleSearch');

// test search
Route::get('/solo_search/{id}', 'SearchResultsController@handleSearch');
Route::get('/solo_search', 'SearchResultsController@soloSearch');

// quick create group

Route::post('/quick-create-group', 'GroupController@store');
