@extends('layout/main')

@section('content')

@if (Session::has('success_message'))
    <div>{{ Session::get('success_message') }}</div>
@endif

    <h2>Overview</h2>
    <p>Name: {{$user->name}}</p>
    @if(Auth::id() == $user->id)
    <p>Email: {{$user->email}}</p>
    <p>Phone number: {{$user->phone}}</p>
    <button><a href="/user/{{$user->id}}/edit">Edit</a></button>
     @endif

<hr>
    @if(Auth::id() == $user->id)
    <h3>My groups:</h3>
    @else
    <h3>{{$user->name}}'s groups:<h3>
    @endif


    @if(Auth::id() == $user->id)

        <h4>Create new group</h4>        
        <form class="form form-create-group" action="/user/{{ $user->id }}/group" method="post">
        @csrf
            <div class="form-create-group_item">
              <label for="name">Name your group</label>
              <input type="text" name="name"/>
            </div>
            <div class="form-create-group_item">
              <input type="submit" value="Submit">
            </div>
        </form>
        
    @endif

        
        <h4>Select group</h4>
        <ul>
    @foreach($user->groups as $group)
        <li><a href="/group/{{$group->id}}">{{ $group->name }}</a></li>
    @endforeach
        </ul>

        <button><a href="">Manage groups</a></button>
        
       

       
@endsection
@push('child-scripts')
<script>
// alert('I\'m coming from child')

// dynamic select
</script>
@endpush