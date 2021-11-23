<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $groupData = [
            'name' => $request->input('groupName'),
            'owner_id' => $request->input('owner_id'),
        ];

        $groupMembers = $request->input('groupMembers');

        $group = Group::create($groupData);
        foreach ($groupMembers as $member) {
            $group->users()->attach($member['id']);
        };

        return [
            'message' => 'group successfuly saved',
            'group_id' => $group->id,
        ];
    }
}
