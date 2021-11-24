@extends('layout/main')

@section('content')

<div class="all_events">
        {{-- DISPLAY SUCCESS MESSAGE --}}
        @if (Session::has('success_message'))
    
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
    
        @endif
        
        {{-- FUTURE EVENTS --}}
        <h2>Future events</h2>
        <div class="future-container">
            @foreach ($venues as $venue)
                
                {{-- CHECK IF VENUE HAS SOME EVENTS --}}
                @if (!$venue->events->isEmpty())
                    <div class="future-event">
                        <h3>{{$venue->name}}</h3>
                        <table class="table-style">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date - start</th>
                                    <th>Time - start</th>
                                    <th>Date - end</th>
                                    <th>Time - end</th>
                                    <th>Price (CZK)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($venue->events as $event)
                                        <tr>
                                            <td>{{$event->name}}</td>
                                            <td>{{$event->start_date}}</td>
                                            <td>{{$event->start_time}}</td>
                                            <td>{{$event->end_date}}</td>
                                            <td>{{$event->end_time}}</td>
                                            <td>{{$event->price}} </td>
                                            <td><button><a href="/admin/event/{{$event->id}}">Edit</a></button>
                                                <form action="/admin/event/{{$event->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
        
                                                    <input type="submit" value="Delete"/>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                @endif
        
            @endforeach
        </div>
    
        {{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
        <p>Note: If you can't see some of your venue it means there are no events!</p>
    
        <div class="line"></div>
    
        {{-- REPEATED EVENTS --}}
        <h2>Repeated events</h2>
        <div class="repeated-container">
            @foreach ($venues_repeat as $venue)
                
                {{-- CHECK IF VENUE HAS SOME EVENTS --}}
                @if (!$venue->events->isEmpty())
                    <div class="repeated-event">
                        <h3>{{$venue->name}}</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Day(s)</th>
                                    <th>Time - start</th>
                                    <th>Time - end</th>
                                    <th>Price (CZK)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($venue->events as $event)
                                        <tr>
                                            <td>{{$event->name}}</td>
                                            <td>
                                            @foreach ($days as $day)
                                                @if ($event->$day == 1)
                                                    {{$day}} <br>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td>{{$event->start_time}}</td>
                                            <td>{{$event->end_time}}</td>
                                            <td>{{$event->price}} </td>
                                            <td><button><a href="/admin/event/{{$event->id}}">Edit</a></button>
                                                <form action="/admin/event/{{$event->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
        
                                                    <input type="submit" value="Delete"/>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        </div>
    
        {{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
        <p>Note: If you can't see some of your venue it means there are no events!</p>
    
        <div class="line"></div>
    
        {{-- HISTORICAL EVENTS --}}
        <h2>Historical events</h2>
         <div class="historical-container">
             @foreach ($venues_hist as $venue)
                
                {{-- CHECK IF VENUE HAS SOME EVENTS --}}
                @if (!$venue->events->isEmpty())
                    <div class="historical-event">
                        <h3>{{$venue->name}}</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date - start</th>
                                    <th>Time - start</th>
                                    <th>Date - end</th>
                                    <th>Time - end</th>
                                    <th>Price (CZK)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($venue->events as $event)
                                        <tr>
                                            <td>{{$event->name}}</td>
                                            <td>{{$event->start_date}}</td>
                                            <td>{{$event->start_time}}</td>
                                            <td>{{$event->end_date}}</td>
                                            <td>{{$event->end_time}}</td>
                                            <td>{{$event->price}} </td>
                                            <td><button><a href="/admin/event/{{$event->id}}">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
         </div>
    {{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
    <p>Note: If you can't see some of your venue it means there are no historical events!</p>
</div>

@endsection


