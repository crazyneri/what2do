<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class SearchController extends Controller
{
    public function fetchData()
    {

        $categories = Category::all();

        return $categories;

    }

}
