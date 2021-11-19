@if ($venue->id === null)
    @extends('layout/main')
    @section('content')

@endif

@foreach ($errors->all() as $message)
    <p>{{$message}}</p>
    
@endforeach

@if ($venue->id === null)
    <form action="/admin/venue/create" method="post">
@else
    <form action="/admin/venue/{{$venue->id}}" method="post">
    @method('put')
@endif

    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="{{old('name', $venue->name)}}"/>
    <br>
    <label for="address">Address:</label>
    <input type="text" name="address" id="address" value="{{old('address', $venue->address)}}"/>
    <br>
    <label for="city">City:</label>
    <input type="text" name="city" id="city" value="{{old('city', $venue->city)}}"/>
    <br>
    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" value="{{old('phone', $venue->phone)}}"/>
    <br>
    <label for="website">Website:</label>
    <input type="text" name="website" id="website" value="{{old('website', $venue->website)}}"/>
    <br>
    <label for="map_link">Map link:</label>
    <input type="text" name="map_link" id="map_link" value="{{old('map_link', $venue->map_link)}}"/>
    <br>

    @if ($venue->id === null)
        <input type="submit" value="Create venue"/>  
    @else
        <input type="submit" value="Edit venue"/>  
    @endif

</form>

@if ($venue->id === null)
   @endsection 
@endif
