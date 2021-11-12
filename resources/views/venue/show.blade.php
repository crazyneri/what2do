@extends('layout/main')

@section('content')

    <h2>{{$venue->name}}</h2>
    <p>Address: {{$venue->address}}</p>
    <p>Email: <a href="mailto:{{$venue->email}}">{{$venue->email}}</a></p>
    <p>Phone: {{$venue->phone}}</p>
    <p>Website: <a href={{$venue->website}} target="_blank">{{$venue->website}}</a></p>

    <iframe
        src={{$venue->map_link}}
        width="600"
        height="450"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
    </iframe>

    <form >

    </form>
    
    
@endsection