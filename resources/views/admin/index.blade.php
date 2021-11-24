@extends('layout/main')

@section('content')

    <div class="admin">
        <h1>Welcome in administration</h1>
    
        {{-- DISPLAY SUCCESS MESSAGE --}}
        @if (Session::has('success_message'))
    
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
    
        @endif
    
        {{-- LIST OF USER'S VENUES --}}
        <div class="admin-container">
            <div class="left-side">
                <h2>List of your venues:</h2>
                <table class="table-style">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Future events</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach ($venues_events as $venue)
                                <tr>
                                    <td>{{$venue->name}}</td>
                                    <td>{{count($venue->events)}}</td>
                                    <td><a href="/admin/venue/{{$venue->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
    
                {{-- EVERY USER CAN HAVE 6 VENUES AT MAX --}}
                @if (count($venues_events) < 6)
                    <button><a href="/admin/venue/create">Add new venue</a></button>
                @else
                    <p>Note: You can have max 6 venues on one admin user account. If you want more PAY MORE!</p>
                @endif
                
            </div>
            
            {{-- LIST OF COMMING EVENTS (limit 5)--}}
            <div class="right-side">
                <h2>Coming soon:</h2>
                <table class="table-style">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Venue</th>
                            <th>Date - start</th>
                            <th>Time - start</th>
                            <th>Date - end</th>
                            <th>Time - end</th>
                            <th>Price (CZK)</th>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->venue->name}}</td>
                                    <td>{{$event->start_date}}</td>
                                    <td>{{$event->start_time}}</td>
                                    <td>{{$event->end_date}}</td>
                                    <td>{{$event->end_time}}</td>
                                    <td>{{$event->price}} </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
        
                <div class="events-btn">
                    <button><a href="/admin/events">See all events</a></button>
                    <button><a href="/admin/event/create">Create event</a></button>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection