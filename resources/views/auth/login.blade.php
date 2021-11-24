@extends('layout/main')

@section('content')

<div class="login">
    <div class="login-message__no-login">
        <h2>Without logging in you can't create group searches or save your results!</h2>
        <form action="{{ route('anonymous-login') }}" method="post">
            @csrf
            <button class="btn-login btn-login__no-login">Continue without Login</button>
        </form>
    </div>
    
    <form class="login-form" action="{{ route('login') }}" method="post">
        @csrf
        
            <div class="login-form-input">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
            </div>
            
            <div class="login-form-input">
                <label for="pass">Password: </label>
                <input type="password" name="password" id="pass" value="">
            </div>
            
            <div class="btn-container"><button class="btn-login btn-login__login">Login</button></div>
    </form>
    
    <div class="btn-create"><button class="btn-login"><a href="/register">Create an account</a></button></div>
</div>

@endsection