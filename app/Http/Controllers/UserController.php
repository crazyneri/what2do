<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $searchEmail = $request->input('email-search');
        // $users = User::where('email', 'like', '%' . $searchEmail . '%')->get();

        // dd($users);
        // return view('user.index', compact('users'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }

    // SHOW INFO ABOUT A USER
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }
    // EDIT USER INFO
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $user->save();

        $request->session()->flash('success_message', 'The details were succesfully updated.');

        return redirect()->action('UserController@show', ['id' => $user->id]);
    }

    public function destroy($id)
    {
        //
    }
    // CREATE NEW GROUP & STORE IDs IN PIVOT
    public function createGroup($id, Request $request)
    {
        $data = $request->all();
        $data['owner_id'] = $id;

        if (Auth::id() == $id) {
            $group = Group::create($data);
            $group->users()->attach($id);
        }

        // $user = User::findOrFail($id); // same result as above
        // $user->groups()->attach($group->id);

        return redirect()->back();

    }

    // should be split in 2 methods (display + work with info)
    public function showGroup($group_id)
    {
        $group = Group::findOrFail($group_id);
        return view('group.show', compact('group'));
    }
    public function groupAddUser(Request $request, $group_id)
    {
        // take a group, add a user to it
        $group = Group::findorFail($group_id);

        // **security feature for when logged in
        if (Auth::id() === $group->owner_id) {
            $user = User::where('email', $request->input('email-search'))->first(); // retrieve single record

            if ($user && $group) {
                if ($group->users()->find($user->id)) {
                    echo 'Already a member.';
                } else {
                    $group->users()->attach($user->id);
                }
            }
        }
        return view('group.show', compact('group', 'user'));
    }

    public function removeFriendget($group_id, $user_id)
    {
        $group = Group::findOrFail($group_id);
        $user = User::findOrFail($user_id);
        dd($group, $user);
    }
    public function removeFriend($group_id, $user_id)
    {
        $group = Group::findOrFail($group_id);
        $user = User::findOrFail($user_id);
        $group->users()->detach($user_id);
        return redirect()->back();
    }

    public function anonymousLogin()
    {
        $user = [
            'id' => 0,
            'name' => "Anonymous User",
            'groups' => [],
        ];
        session(['user' => $user]);

        return redirect()->route('search');

    }
}
