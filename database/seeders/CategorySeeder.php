<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DELETE ALL DATA
        DB::table('categories')->truncate();

        $categories = json_decode(file_get_contents(storage_path('categories.json')));

        foreach($categories as $category){
            $cat = new Category;
            $cat->name = $category->name;
            $cat->parent_id = $category->parent_id;
            $cat->save();
        }
    }
}
