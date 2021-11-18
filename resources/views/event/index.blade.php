@extends('layout/main')

@section('content')
    
    {{-- FUTURE EVENTS --}}
    <h2>Future events</h2>
    <div class="future-container">
        @foreach ($venues as $venue)
            
            {{-- CHECK IF VENUE HAS SOME EVENTS --}}
            @if (!$venue->events->isEmpty())
                <div class="future-event">
                    <h3>{{$venue->name}}</h3>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Date - start</th>
                            <th>Time - start</th>
                            <th>Date - end</th>
                            <th>Time - end</th>
                            <th>Price</th>
                            <th>Action</th>
                            @foreach ($venue->events as $event)
                                <tr>
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->start_date}}</td>
                                    <td>{{$event->start_time}}</td>
                                    <td>{{$event->end_date}}</td>
                                    <td>{{$event->end_time}}</td>
                                    <td>{{$event->price . " CZK"}} </td>
                                    <td><a href="/event/{{$event->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @endif
    
        @endforeach
    </div>

    {{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
    <p>Note: If you can't see some of your venue it means there are no events!</p>

    {{-- REPEATED EVENTS --}}
    <h2>Repeated events</h2>
    <div class="repeated-container">
        @foreach ($venues as $venue)
            
            {{-- CHECK IF VENUE HAS SOME EVENTS --}}
            @if (!$venue->events->isEmpty())
                <div class="future-event">
                    <h3>{{$venue->name}}</h3>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Date - start</th>
                            <th>Time - start</th>
                            <th>Date - end</th>
                            <th>Time - end</th>
                            <th>Price</th>
                            <th>Action</th>
                            @foreach ($venue->events as $event)
                                <tr>
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->start_date}}</td>
                                    <td>{{$event->start_time}}</td>
                                    <td>{{$event->end_date}}</td>
                                    <td>{{$event->end_time}}</td>
                                    <td>{{$event->price . " CZK"}} </td>
                                    <td><a href="/event/{{$event->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @endif
    
        @endforeach
    </div>

    {{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
    <p>Note: If you can't see some of your venue it means there are no events!</p>

    {{-- HISTORICAL EVENTS --}}
    <h2>Historical events</h2>


     <div class="historical-container">
         @foreach ($venues_hist as $venue)
            
            {{-- CHECK IF VENUE HAS SOME EVENTS --}}
            @if (!$venue->events->isEmpty())
                <div class="historical-event">
                    <h3>{{$venue->name}}</h3>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Date - start</th>
                            <th>Time - start</th>
                            <th>Date - end</th>
                            <th>Time - end</th>
                            <th>Price</th>
                            <th>Action</th>
                            @foreach ($venue->events as $event)
                                <tr>
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->start_date}}</td>
                                    <td>{{$event->start_time}}</td>
                                    <td>{{$event->end_date}}</td>
                                    <td>{{$event->end_time}}</td>
                                    <td>{{$event->price . " CZK"}} </td>
                                    <td><a href="/event/{{$event->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @endif
        @endforeach
     </div>
{{-- DISPLAY MESSAGE NO FUTURE EVENTS --}}
<p>Note: If you can't see some of your venue it means there are no historical events!</p>


