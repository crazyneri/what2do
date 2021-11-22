@extends('layout/main')

@section('content')

<div>
    <h2>Without logging in you can't create group searches or save your results!</h2>
    <form action="{{ route('anonymous-login') }}" method="post">
        @csrf
        <button>Continue without Login</button>
    </form>
</div>

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

<div><button><a href="/register">Create an account</a></button></div>

@endsection