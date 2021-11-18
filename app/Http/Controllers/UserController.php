<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Group;
use Auth;

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

        return view('user.edit',compact('user'));
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
        // dd($id, $request->all());

        $data = $request->all();
        $data['owner_id'] = $id;
        // dd($data);

        $group = Group::create($data);
        $group->users()->attach($id);
        
        // $user = User::findOrFail($id); // same result as above
        // $user->groups()->attach($group->id);

        return redirect()->back();
        
    }

    public function addFriend($id)
    {
        $user = User::findOrFail($id);
        dd($id);
        return view('user.add', compact('user'));
    }

    public function groupAddUser(Request $request, $group_id)
    {
        // take a group, add a user to it
        $group = Group::findorFail($group_id);
        

        // **security feature for when logged in
        // if(Auth::user()->id === $group->owner_id){
        $user = User::where('email', $request->input('email-search'))->first(); // retrieve single record
        
        if($user && $group)
        {
            if($group->users()->find($user->id)){
            echo 'Already a member.';
            } else{
            $group->users()->attach($user->id);
            }
        }
    //   }
        return view('group.show', compact('group','user'));
    }

}
