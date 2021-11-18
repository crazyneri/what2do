<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// populate the Search Page with categories to use on DragAndDrop component

Route::get('/search', 'Api\SearchController@fetchData');

Route::get('/user', 'Api\SearchController@getUser'
// function () {

    // return [
    //     'user' => Auth::user(),
    // ];
    // return [
    //     'user' => [
    //         'name' => 'James Bond',
    //     ],
    // ];

// }
);
