@extends('layout/main')

@section('content')

    {{-- LOG OUT BUTTON --}}
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button>Logout</button>
    </form>
    
@endsection