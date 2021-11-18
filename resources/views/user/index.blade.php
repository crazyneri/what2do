@extends('layout/main')

@section('content')
    <h4>Search friends</h4>
    {{-- <form action="/users" method="get">
        <input class="search-friends" type="text" name="email-search"/>
        <button>Select</button>
    </form> --}}

    <ul class="users-list">
    @foreach ($users as $user)
    @if($user->role === 'NULL')
        <li><a href="/user/{{ $user->id }}/add">{{ $user->email}} </a></li>
    @endif
    @endforeach
    </ul>
@endsection