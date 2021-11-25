@extends('layout/main')

@section('content')
<div class="user-container">
    <div class="user-item">
    <h3>My group's name:</h3> 
    <p>{{ $group->name }}</p>
@if(Auth::id()==$group->owner_id)
<h4>Search friends to add</h4>
    <form id="add-user" action="/group/{{$group->id}}" method="post">
    @csrf
        <input class="search-friends" type="hidden" name="group_id" value="{{$group->id}}"/>
        <input class="search-friends" type="text" name="email-search" placeholder="email"/>
        <button type="submit">Add</button>
    </form>
</div>
@endif
{{-- <hr> --}}
    <h4>Members of {{ $group->name }}:</h4>
    <ul class="">
    @foreach($group->users as $user)
    @if($user->id === $group->owner_id)
        <div class="group-display-members"><li>{{$user->name}}, owner <img class="img-group-owner" src="/img/butterfly/butterfly.svg"/></li></div>
        
        @else
        <div class="group-display-members">
            <li>{{$user->name}}</li>
        @if(Auth::id()==$group->owner_id)
            <form action="/group/{{$group->id}}/user/{{$user->id}}" method="post">
                @csrf  
                @method('delete')  
                <button class="btn btn-group-remove">Remove</button>
            </form>
        @endif
        </div>
        
    @endif
    @endforeach
    </ul>
</div>
@endsection