@extends('layout/main')

@section('content')

    {{-- SHOW SUCCESS MESSAGE --}}
    @if (Session::has('success_message'))

        <div class="alert alert-success">
            {{ Session::get('success_message') }}
        </div>

    @endif

    {{-- INFORMATION ABOUT VENUE --}}
    <div class="venue-container">
        <div class="left-side">
            <h2>{{$venue->name}}</h2>
            <p>Address: {{$venue->address}}</p>
            <p>Email: <a href="mailto:{{$venue->email}}">{{$venue->email}}</a></p>
            <p>Phone: {{$venue->phone}}</p>
            <p>Website: <a href={{$venue->website}} target="_blank">{{$venue->website}}</a></p>
        
            {{-- MAP IS DISPLAYED ONLY IF EMBEDED LINK IS PROVIDED --}}
            @if (strpos($venue->map_link, 'embed') !== false) 
                <iframe
                    src={{$venue->map_link}}
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            @endif
    
            </div>
    
            {{-- FUTURE EVENTS IN THE VENUE --}}
            <div class="right-side">
                <h2>Future events in {{$venue->name}}:</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Date - start</th>
                        <th>Time - start</th>
                        <th>Date - end</th>
                        <th>Time - end</th>
                        <th>Price</th>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$event->name}}</td>
                                <td>{{$event->start_date}}</td>
                                <td>{{$event->start_time}}</td>
                                <td>{{$event->end_date}}</td>
                                <td>{{$event->end_time}}</td>
                                <td>{{$event->price . " CZK"}} </td>
                            </tr>
                        @endforeach
                    </tr>
                </table>
            </div>
    </div>

    {{-- INCLUDE FORM --}}
    <div class="edit-form">
        <h2>Edit information about {{$venue->name}}</h2>
        @include('venue/form')
    </div>
    

    
    
@endsection