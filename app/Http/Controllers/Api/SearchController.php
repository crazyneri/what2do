<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function fetchData()
    {

        $categories = Category::all();

        $categoriesObject = [];

        foreach ($categories as $category) {

            if (!isset($categoriesObject[strtolower($category->name)])) {

                $categoriesObject[strtolower($category->name)] = [
                    'id' => strtolower($category->name),
                    'name' => $category->name,
                    'categoryId' => $category->id,
                    'parent_id' => $category->parent_id,
                ];
            };
        };

        $columnsObject = [

            'categories' => [
                'id' => 'categories',
                'title' => 'Categories',
                'columnType' => 'main',
                'categoryId' => 0,
                'categoryIds' =>

                $categories->filter(function ($cat) {
                    return $cat['parent_id'] === 0;
                })
                    ->map(function ($c) {
                        return strtolower($c->name);
                    },

                    ),
            ],
            'what2do' => [
                'id' => 'what2do',
                'title' => 'what2do',
                'columnType' => 'main',
                'categoryId' => 0,
                'categoryIds' => [],
            ],
            'empty-sub-categories' => [
                'id' => 'empty-sub-categories',
                'title' => 'Instructions:',
                'columnType' => 'main',
                'categoryId' => 0,
                'categoryIds' => [],

            ],
        ];

        foreach ($categories as $category) {

            $titleString_pref = ucfirst("{$category->name} choices");

            $titleString_sub = ucfirst("{$category->name} categories");


            $lowerCaseName = strtolower($category->name);

            $preferencesString = "{$lowerCaseName}-preferences";

            $subcategoriesString = "{$lowerCaseName}-sub-categories";

            if ($category->parent_id === 0) {
                $columnsObject[$preferencesString] = [
                    'id' => $preferencesString,
                    'title' => $titleString_pref,
                    'columnType' => 'sub',
                    'categoryId' => $category->id,
                    'categoryIds' => [],
                ];

                $columnsObject[$subcategoriesString] = [
                    'id' => $subcategoriesString,
                    'title' => $titleString_sub,
                    'columnType' => 'sub',
                    'categoryId' => $category->id,
                    'categoryIds' => array_values(
                        $categories->filter(function ($cat) use ($category) {
                            return $cat->parent_id === $category->id;
                        })->map(function ($c) {return strtolower($c->name);})->toArray()),

                ];

            }

        }

        // building the initial state object containing all the data
        $data =

            [

            'categories' => $categoriesObject,

            'columns' => $columnsObject,

            'columnOrder' => [
                'categories',
                'what2do',
                'cinema-preferences',
                'music-preferences',
                'theater-preferences',
                'cinema-sub-categories',
                'music-sub-categories',
                'theater-sub-categories',
                'empty-sub-categories',
            ],

        ];

        return $data;
    }

    public function getUser()
    {
        $user = Auth::user();

        if (isset($user)) {
            $user->load(['groups', 'groups.users', 'groups.search_sessions']);
        } else {
            $user = session('user') ?? null;
        };

        return $user;

    }

    public function getAllUsers()
    {
        $users = User::all();

        $userNames = $users->map->only(['id', 'name'])->filter(function ($user) {
            return $user['name'] !== 'Anonymous User';
        });

        return $userNames;
    }

}
