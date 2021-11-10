<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DELETE ALL DATA
        DB::table('users')->truncate();

        $users = json_decode(file_get_contents(storage_path('admin_users.json')));

        foreach($users as $user){
            $usr = new User;
            $usr->role = $user->role;
            $usr->name = $user->name;
            $usr->email = $user->email;
            $usr->password = bcrypt($user->password);
            $usr->phone = $user->phone;
            $usr->gender = $user->gender;
            $usr->save();
        }
    }
}