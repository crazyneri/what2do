@extends('layout/main')

@section('content')

    <h1>Search sessions</h1>


    {{-- LIST OF USER'S SEARCH SESSIONS --}}
   
      <div class="left-side">
        <h2>List of your completed searches:</h2>
        <table class="table-style">
          <thead>
            <tr>
              <th>Group</th>
              <th>City</th>
              <th>Date</th>
              <th>Time - start</th>
              <th>Time - end</th>
              <th>Joined users<th>
                <th>Event</th>
              </tr>
            </thead>
            <tbody>
                  @foreach($user_sessions->search_sessions as $session)
                      @if($session->event_id != null)
                            <tr>
                                <td>{{$session->group->name}}</td>
                                <td>{{$session->city}}</td>
                                <td>{{$session->date}}</td>
                                <td>{{$session->start_time}}</td>
                                <td>{{$session->end_time}}</td>
                                <td>
                                @foreach ($session->user_choices as $user)
                                {{$user->user->name}}</br>
                                @endforeach
                                </td>
                                <td>{{$session->event_id}}</td>
                            </tr>
                      @endif
                  @endforeach
              </tbody>
            </table>
        </div>
        
        {{-- LIST OF OPEN SESSIONS --}}
        <div class="right-side">
          <h2>Search invites:</h2>
          <table class="table-style">
            <thead>
              <tr>
                <th>Group</th>
                <th>City</th>
                <th>Date</th>
                <th>Time - start</th>
                <th>Time - end</th>
                <th>Joined users</th>
                  <th>Join search</th>
                </tr>
              </thead>
              <tbody>
                      @foreach($user_sessions->search_sessions as $session)
                        @if($session->event_id == null)
                            <tr>
                                <td>{{$session->group->name}}</td>
                                <td>{{$session->city}}</td>
                                <td>{{$session->date}}</td>
                                <td>{{$session->start_time}}</td>
                                <td>{{$session->end_time}}</td>
                                <td>
                                @foreach ($session->user_choices as $user)
                                {{$user->user->name}}</br>
                                @endforeach
                                </td>
                                <td><a href="#"><button>Join search!</button></a></td>
                            </tr>
                          @endif
                        @endforeach
                    </tbody>
            </table>
        </div>

   
    
    
@endsection