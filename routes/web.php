<?php

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
Route::get('venue/{id}', 'VenueController@show');
Route::get('/admin/venue/create', 'VenueController@create');
Route::post('/admin/venue/create', 'VenueController@store');

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
