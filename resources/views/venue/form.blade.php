<form action="/admin/venue/create" method="post">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" id="name"/>
    <br>
    <label for="address">Address:</label>
    <input type="text" name="address" id="address"/>
    <br>
    <label for="city">City:</label>
    <input type="text" name="city" id="city"/>
    <br>
    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone"/>
    <br>
    <label for="website">Website:</label>
    <input type="text" name="website" id="website"/>
    <br>
    <label for="map_link">Map link:</label>
    <input type="text" name="map_link" id="map_link"/>
    <br>
    <input type="submit" value="Create venue"/>  

</form>