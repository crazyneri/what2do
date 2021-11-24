@extends('layout\main')

@section('content')

<h2>{{$event->name}}</h2>
{{-- <h4>Event match score: {{$group_choices[0]['score']}}</h4> --}}
<h4>Event match score: {{$score}}</h4>
<p>Venue: {{$event->venue->name}}</p>
<p>{{$event->description}}</p>
<p>Starts at: {{$event->start_time}}</p>
<p>Ends at: {{$event->end_time}}</p>
<p>Address: {{$event->venue->address}}</p>
<a href="{{$event->venue->website}}">{{$event->venue->name}}</a>
@if (strpos($event->venue->map_link, 'embed') !== false) 
                <iframe
                    src={{$event->venue->map_link}}
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            @endif

@endsection