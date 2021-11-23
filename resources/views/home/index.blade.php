@extends('layout/main')

@section('content')

{{-- LOG IN BUTTON --}}
<button><a href="/login">Login</a></button>

{{-- LOG OUT BUTTON --}}
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button>Logout</button>
</form>

@endsection