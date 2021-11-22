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

        $session_id = $request->input('session_id');

        $user_choice = UserChoice::create($userChoicesData);

        $user_choices_id = $user_choice->id;

        // handleSearch($session_id,$user_choices_id);

        return $user_choice;
    }
}
