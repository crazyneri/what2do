@extends('layout/main')

@section('content')
<h2>Edit user details</h2>

<form action="/user/{{ $user->id }}" method="post">
@csrf
    <div>
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="{{old('name'), $user->name}}"/>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{old('email'), $user->email}}"/>
        </div>
        <div>
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{old('phone'), $user->phone}}" placeholder="602 555 555"/>
        </div>
        <button>Save</button>
    </div>

@endsection