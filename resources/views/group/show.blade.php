@extends('layout/main')

@section('content')
    <h3>My group's name: {{ $group->name }}</h3>
<hr>
<h4>Search friends</h4>
    <form id="add-user" action="/group/{{$group->id}}" method="post">
    @csrf
        <input class="search-friends" type="hidden" name="group_id" value="{{$group->id}}"/>
        <input class="search-friends" type="text" name="email-search" placeholder="email"/>
        <button type="submit">Add</button>
    </form>
<hr>
    <h4>Members of group:</h4>
    <ul>
    @foreach($group->users as $user)
    @if($user->id === $group->owner_id)
        <li>{{$user->name}}, the owner</li>
    @else
        <li>{{$user->name}}</li>
    @endif
    @endforeach
    </ul>
@endsection