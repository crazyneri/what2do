@extends('layout/main')

@section('content')

<div class="user-container">
    @if (Session::has('success_message'))
        <div>{{ Session::get('success_message') }}</div>
    @endif
    
        <div class="user-item">
            <div class="user-header">
                <h2>Personal Details</h2>
                <button><a href="/user/{{$user->id}}/edit">Edit</a></button>
            </div>
            <p>Name: {{$user->name}}</p>
            @if(Auth::id() == $user->id)
            <p>Email: {{$user->email}}</p>
            <p>Phone number: {{$user->phone}}</p>
             @endif
        </div>
    
        @can('admin')
        <div class="user-item">
            <div class="user-header">
                <h2>Venues & Events</h2>
                     <button><a href="/admin">Manage</a></button>
            </div>
                </div>
             @endcan
         
    
             <div class="user-item">
             @if(Auth::id() == $user->id)
            <div class="user-header">
            <h3>My groups:</h3>
            </div>
            @else
            <div class="user-header">
            <h3>{{$user->name}}'s groups:<h3>
            </div>
            @endif
        
        
            @if(Auth::id() == $user->id)
        
                <h4>Create new group</h4>        
                <form class="form form-create-group" action="/user/{{ $user->id }}/group" method="post">
                @csrf
                    <div class="form-create-group_item">
                      <label for="name">Name your group</label>
                      <input type="text" name="name"/>
                    </div>
                    {{-- <div class="form-create-group_item"> --}}
                      <input type="submit" value="Submit">
                    {{-- </div> --}}
                </form>
                {{-- </div> --}}
                
                @endif
        
    
            
           {{-- <div class="user-item"> --}}
                <div class="select-group">
                    <h4>Select group</h4>
                    <ul>
                @foreach($user->groups as $group)
                @if($user->id !== $group->id)
                    <li><a href="/group/{{$group->id}}">{{ $group->name }}</a></li>
                @endif
                @endforeach
                    </ul>
                </div>
        
                {{-- <button><a href="">Manage groups</a></button> --}}
        </div>
        
        
    </div>
    
            @include('search/sessions')
        
@endsection
@push('child-scripts')
<script>
// alert('I\'m coming from child')

// dynamic select
</script>
@endpush