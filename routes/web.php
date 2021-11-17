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
