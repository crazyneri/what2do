@extends('layout/main')

@section('content')

{{-- LOG IN BUTTON --}}
{{-- <button><a href="/login">Login</a></button> --}}

<<<<<<< Updated upstream
=======
@if(Auth::check() == true) 
>>>>>>> Stashed changes
{{-- LOG OUT BUTTON --}}
<form action="{{ route('logout') }}" method="post">
    @csrf

    <button>Logout</button>
</form>
@endif
@endsection