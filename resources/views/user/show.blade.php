@extends('layout/main')

@section('content')

@if (Session::has('success_message'))
    <div>{{ Session::get('success_message') }}</div>
@endif

    <h2>Overview</h2>
    <p>Name: {{$user->name}}</p>
    <p>Email: {{$user->email}}</p>
    <p>Phone number: {{$user->phone}}</p>

<hr>
    <h3>My groups</h3>
<hr>
        @if(Auth::check())

            <h4>Create new group</h4>        
            <form action="/user/{{ $user->id }}/group" method="post">
                @csrf
                <div class="create-group">
                    <label for="name">Create new group</label>
                    <input type="text" name="name"/>
                </div>
                <input type="submit">
            </form>
        
        @endif
<hr>
        
        <h4>Select group</h4>
        @foreach($user->groups as $group)
            <li><a href="/group/{{$group->id}}">{{ $group->name }}</a></li>
        @endforeach
        
       
<hr>
        
        <div>
            <label>SELECT GROUP</label>
            <select name="user_id">
                @foreach($user->groups as $group)
                  <option value="{$group->id}">{{$group->name}}</option>
                @endforeach
            </select>
        </div>
       
@endsection
@push('child-scripts')
<script>
// alert('I\'m coming from child')

// dynamic select
</script>
@endpush