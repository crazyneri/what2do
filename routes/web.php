<?php

use App\Mail\TestEmail;
use App\Models\User;
use App\Notifications\InvoicePaid;
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
Route::get('/admin', 'AdminController@show');

// VENUE PART
Route::get('/venue/{id}', 'VenueController@show');
Route::get('/admin/venue/create', 'VenueController@create');
Route::post('/admin/venue/create', 'VenueController@store');

// SEARCH PART
Route::get('/search', 'SearchController@index');

// USER PART
Route::get('/users', 'UserController@index');
Route::get('/user/{id}', 'UserController@show');
Route::get('/user/{id}/edit', 'UserController@edit');
Route::post('/user/{id}', 'UserController@update');
Route::post('/user/{id}/group', 'UserController@createGroup');
Route::get('/user/{id}/add', 'UserController@addFriend');

// add user to group
Route::post('/group/{id}', 'UserController@groupAddUser');
Route::post('/venue/create', 'VenueController@store');
Route::get('/venue/{id}/edit', 'VenueController@edit');
Route::put('/venue/{id}', 'VenueController@update');

// EVENT PART
Route::get('/admin/events', 'EventController@index');
Route::view('/admin/event/create', 'event/form');
Route::get('/admin/event/data', 'EventController@data');
Route::post('/admin/event/data', 'EventController@store');

// EMAIL PART
// registration - CHANGE SENDING EMAIL AFTER THE REGISTRATION
Route::get('/send-email', function () {
    Mail::to('user@email.com')->send(new TestEmail());
});

// notification - GROUP and USERS NEEDS TO BE ADDED
Route::get('/send-notification', function () {
    $user = User::where('name', 'Jachym Pivonka')->first();

    $user->notify(new InvoicePaid);
});
// dummy search
Route::get('/solo_search', 'SearchResultsController@soloSearch');

// quick create group

Route::post('/quick-create-group', 'GroupController@store');
