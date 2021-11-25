@extends('layout/main')

@section('content')

   <div class="login">
        @foreach ($errors->all() as $error)
            <div class="error">{{ $error }}</div>
        @endforeach
     
        <form class="login-form" action="{{ route('register') }}" method="post">
            @csrf
        
            <div class="login-form-input">
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
            </div>
            <div class="login-form-input">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
            </div>
            <div class="login-form-input">
                <label for="pass">Password: </label>
                <input type="password" name="password" id="pass" value="">
            </div>
            <div class="login-form-input">
                <label for="passConf">Password: </label>
                <input type="password" name="password_confirmation" id="passConf" value="">
            </div>
            <div class="btn-container"><button class="btn-login btn-login_2 btn-login__login">Register</button></div>
     
        </form>
   </div>

@endsection