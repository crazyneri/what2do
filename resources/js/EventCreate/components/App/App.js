import axios from "axios"
import { useState, useEffect } from "react";
import CategorySelection from "../CategorySelection/CategorySelection";

export default function App({id})
{

// STATE FOR GETTING DATA FROM BACKEND
const [venues, setVenues] = useState(null);
const [categories, setCategories] = useState(null);

// STATE FOR KEEPING SELECTED MAIN CATEGORY
const [selectedMainCategory, setSelectedMainCategory] = useState('');

// STATE FOR REST INPUT
const [input, setInput] = useState({
    name: "",
    venue_id: "",
    start_date: "",
    start_time: "",
    end_date: "",
    end_time: "",
    description: "",
    price: "",
    is_recurring: 0,
    monday: 0,
    tuesday: 0,
    wednesday: 0,
    thursday: 0,
    friday: 0,
    saturday: 0,
    sunday: 0,
    categories: null
});

// GET DATA - venues and categories
const getData = async() => {
    const response = await axios.get('/admin/event/data', {
        headers: {
            'Accept': 'Application/json',
            'Content-type': 'Application/json'
        }
    });
    setVenues(response.data.venues);
    setCategories(response.data.categories);
}

// GET DATA - event with id
const getDataEvents = async() => {
    const response = await axios.get(`/admin/event/${id}/edit`, {
        headers: {
            'Accept': 'Application/json',
            'Content-type': 'Application/json'
        }
    });
    setInput({
        name: response.data.name,
        venue_id: response.data.venue_id,
        start_date: response.data.start_date,
        start_time: response.data.start_time,
        end_date: response.data.end_date,
        end_time: response.data.end_time,
        description: response.data.description,
        price: response.data.price,
        is_recurring: response.data.is_recurring == 1, 
        monday: response.data.monday == 1,
        tuesday: response.data.tuesday == 1,
        wednesday: response.data.wednesday == 1,
        thursday: response.data.thursday == 1,
        friday: response.data.friday == 1,
        saturday: response.data.saturday == 1,
        sunday: response.data.sunday == 1,
        categories: response.data.categories.map((category)=>(category.id))
    });
    setSelectedMainCategory(
        response.data.categories[0].parent_id
    )
}

// DAYS OF WEEK
const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

// GET VALUE OF CHECKBOXES - SUBCATEGORIES
const getChecked = () => {
    const checkboxes = document.querySelectorAll('.checkbox');
    const checked = [];
    for(let i = 0; i < checkboxes.length; i++ ){
        if(checkboxes[i].checked == true){
            checked.push(checkboxes[i].value);
        }
    }
    setInput(
        {...input,
        ['categories']:checked}
    )  
}

// USE EFFECT
useEffect(() => {
    getData();
    if(id) {
        getDataEvents();
    }
},[]);

// SEND THE DATA TO THE DB
const handleSubmit = async(event) => {
    event.preventDefault();
    try{
        if(id) {
            let response = await axios.put(`/admin/event/${id}/update`, {...input}, {
            headers: {
                'Accept': 'application/json'
            }
            });
        }else {
            let response = await axios.post('/admin/event/store', {...input}, {
            headers: {
                'Accept': 'application/json'
            }
            });
        }
        
            // redirect to the events page
            window.location.replace("/admin/events");

        } catch (error) {
            
        }
}

// SAVE OTHER INPUTS
const saveInput = (e) => {
    let value = e.target.value;
    const name = e.target.name;
    setInput(
        {...input, 
        [name]:value}
    )
}

// SAVE CHECKBOX
const saveCheckbox = (e) => {
    let value = e.target.checked ? 1 : 0;
    const name = e.target.name;
    setInput(
        {...input, 
        [name]:value}
    )
}

    return(    
        <form action={{id} ? `/admin/event/${id}/update` : '/admin/event/data'}  method='post' onSubmit={handleSubmit} className="event-form">
            <div className="create-form">
                <div className="first-part">
                    <label htmlFor="name">Name:</label>
                    <input type="text" name="name" id="name" value={input.name} onChange={saveInput}/>

                    <label htmlFor="start_date">Start date:</label>
                    <input type="date" name="start_date" id="start_date" value={input.start_date} onChange={saveInput}/>
                    
                    <label htmlFor="start_time">Start time:</label>
                    <input type="time" name="start_time" id="start_time" value={input.start_time} onChange={saveInput}/>

                    <CategorySelection
                            categories={categories}
                            subcategories={input.categories}
                            setSubcategories={(categories) => setInput({...input, categories})}
                            selectedMainCategory={selectedMainCategory}
                            setSelectedMainCategory={setSelectedMainCategory}
                            />
                </div>
                <div className="second-part">

                    <label>Venue:</label>
                    <select name="venue_id" onChange={saveInput}>
                        <option>-- select your venue --</option>
                        {
                            venues &&
                            venues.map((venue, index) => (
                                    <option key={index} selected={input.venue_id} value={venue.id}>{venue.name}</option>
                                
                        ))
                        }                
                    </select>
                    
                    <label htmlFor="end_date">End date:</label>
                    <input type="date" name="end_date" id="end_date" value={input.end_date} onChange={saveInput}/>
                    
                    <label htmlFor="end_time">End time:</label>
                    <input type="time" name="end_time" id="end_time" value={input.end_time} onChange={saveInput}/>
                    
                    <label htmlFor="price">Price:</label>
                    <input type="number" name="price" id="price" value={input.price} onChange={saveInput}/>
                    

                   <div className="repeated-label">
                        <label htmlFor="is_recurring">Repeated event?</label>
                        <input type="checkbox" name="is_recurring" id="is_recurring" checked={input.is_recurring} onChange={saveCheckbox}/>
                   </div>
                    
                    <div className="repeated-days">
                        {
                            days.map((day, index) => (
                                input.is_recurring == 1 ?
                                <div key={index}>
                                <label htmlFor="dayofweek">{day}</label>
                                <input className="dayofweek" type="checkbox" checked={input[day]} name={day} value={input[day]} onChange={saveCheckbox}/>
                                <br/>
                                </div>
                                :
                                ''
        
                            ))
                            
                        }
                    </div>
                    
                </div>
                
            </div>
            <div className="third-part">
                    <label htmlFor="description">Description:</label>
                    <textarea name="description" rows="4" id="description" value={input.description} onChange={saveInput}></textarea>
    
                    {
                        id ?
                        <button onClick={() => getChecked()}>Edit event</button>
                        :
                        <button onClick={() => getChecked()}>Create event</button>
                    }
                </div>
        </form>
        
    )
}