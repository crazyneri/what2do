<form action="/admin/event/create" method="post">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" id="name"/>
    <br>
    <label>Venue:</label>
    <select name="venue_id">
        @foreach ($venues as $venue)
            <option value="{{$venue->id}}">{{$venue->name}}</option>
        @endforeach
    </select>
    <br>
    <label for="start_date">Start date:</label>
    <input type="date" name="start_date" id="start_date"/>
    <br>
    <label for="start_time">Start time:</label>
    <input type="time" name="start_time" id="start_time"/>
    <br>
    <label for="end_date">End date:</label>
    <input type="date" name="end_date" id="end_date"/>
    <br>
    <label for="end_time">End time:</label>
    <input type="time" name="end_time" id="end_time"/>
    <br>
    <label for="description">Descriptiom:</label>
    <textarea name="description" id="description"></textarea>
    <br>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price"/>
    <br>
    <input type="submit" value="Create event"/>  

</form>