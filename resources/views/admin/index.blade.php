@extends('layout/main')

@section('content')

    <h1>{{$user->name}}, welcome in administration</h1>

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
            <table>
                <tr>
                    <th>Name</th>
                    <th>Future events</th>
                    <th>Edit</th>
                    @foreach ($user->venues as $venue)
                        <tr>
                            <td>{{$venue->name}}</td>
                            <td></td>
                            <td><a href="/venue/{{$venue->id}}">Edit</a></td>
                        </tr>
                    @endforeach
                </tr>
            </table>
    
            <button><a href="/admin/venue/create">Add new venue</a></button>
    
        </div>
        
        {{-- LIST OF COMMING EVENTS (limit 5)--}}
        <div class="right-side">
            <h2>Comming soon:</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Venue</th>
                    <th>Date - start</th>
                    <th>Time - start</th>
                    <th>Date - end</th>
                    <th>Time - end</th>
                    <th>Price</th>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{$event->name}}</td>
                            <td>{{$event->venue->name}}</td>
                            <td>{{$event->start_date}}</td>
                            <td>{{$event->start_time}}</td>
                            <td>{{$event->end_date}}</td>
                            <td>{{$event->end_time}}</td>
                            <td>{{$event->price . " Kc"}} </td>
                        </tr>
                    @endforeach
                </tr>
            </table>
    
            <button><a href="/events">See all events</a></button>
            <button><a href="/event/create">Create event</a></button>
        </div>
    </div>
    
    
@endsection