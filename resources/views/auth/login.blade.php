@extends('layout/main')

@section('content')

    <form action="{{ route('login') }}" method="post">
    @csrf
 
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">
    <br>
    <label for="pass">Password: </label>
    <input type="password" name="password" id="pass" value="">
    <br>
    <button>Login</button>
 
</form>

@endsection