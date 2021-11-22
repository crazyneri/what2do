<?php

namespace App\Http\Controllers;

use App\Models\UserChoice;
use Illuminate\Http\Request;

class UserChoiceController extends Controller
{
    public function store(Request $request)
    {
        $userChoicesData = [
            'session_id' => $request->input('session_id'),
            'user_id' => $request->input('user_id'),
        ];

        $category_ids = $request->input('category_ids');

        foreach ($category_ids as $i => $id) {

            $index = $i + 1;

            $string = "category{$index}_id";

            $userChoicesData[$string] = $id;
        };

        $user_choice = UserChoice::create($userChoicesData);

        return $user_choice;
    }
}
