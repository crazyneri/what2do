@extends('layout/main')

@section('content')
<div class="user-container">
    <div class="user-item">
        <div class="user-header-edit">
            <h2>Edit details</h2>
                    </div>

            <form class="form-edit-user" action="/user/{{ $user->id }}" method="post">
            @csrf
                {{-- <div> --}}
                    <div class="form-edit-item">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{old('name'), $user->name}}"/>
                    </div>
                    <div class="form-edit-item">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{old('email'), $user->email}}"/>
                    </div>
                    <div class="form-edit-item">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" value="{{old('phone'), $user->phone}}" placeholder="602 555 555"/>
                    </div>
                    <div class="user-edit-btn"><button>Save</button></div>
                {{-- </div> --}}
    </div>
</div>

@endsection