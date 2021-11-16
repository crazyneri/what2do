import axios from "axios"
import { useState, useEffect } from "react";

export default function App()
{
const [venues, setVenues] = useState([]);

const fetchData = async() => {
    const response = await axios.get('/admin/event/data', {
        headers: {
            'Accept': 'Application/json',
            'Content-type': 'Application/json'
        }
    });
    setVenues(response.data.venues);
}

useEffect(() => {
    fetchData();
},[]);

// console.log(data.venues);

    return(
        <div className="create-form">
            <form>
                <label htmlFor="name">Name:</label>
                <input type="text" name="name" id="name"/>
                <br/>
                <label>Venue:</label>
                <select name="venue_id">
                    {
                        venues.map((venue, index) => (
                                <option key={index} value={venue.id}>{venue.name}</option>
                            
                    ))
                    }
                    
                
                </select>
                <br/>

            </form>
        </div>
    )
}