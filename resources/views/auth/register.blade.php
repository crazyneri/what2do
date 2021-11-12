@extends('layout/main')

@section('content')

    @foreach ($errors->all() as $error)
        <div class="error">{{ $error }}</div>
    @endforeach
 
    <form action="{{ route('register') }}" method="post">
        @csrf
    
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        <br>
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        <br>
        <label for="pass">Password: </label>
        <input type="password" name="password" id="pass" value="">
        <br>
        <label for="passConf">Password: </label>
        <input type="password" name="password_confirmation" id="passConf" value="">
        <br>
        <button>Register</button>
 
    </form>

@endsection