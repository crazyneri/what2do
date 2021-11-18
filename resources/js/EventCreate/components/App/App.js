import axios from "axios"
import { useState, useEffect } from "react";
import CategorySelection from "../CategorySelection/CategorySelection";

export default function App()
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
})

// GET DATA
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
},[]);

// SEND THE DATA TO THE DB
const handleSubmit = async(event) => {
    event.preventDefault();

    let response = await axios.post('/admin/event/store', {...input}, {
        headers: {
                'Accept': 'application/json'
            }
    });
    console.log(response);
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

// console.log(selectedMainCategory);
// console.log(selectedSubCategory);
// console.log(recurring);
// console.log(recDays);
console.log(input);

    return(
        <div className="create-form">
            <form action='/admin/event/data' method='post' onSubmit={handleSubmit}>
                <label htmlFor="name">Name:</label>
                <input type="text" name="name" id="name" onChange={saveInput}/>
                <br/>
                <label>Venue:</label>
                <select name="venue_id" onChange={saveInput}>
                    <option>-- select your venue --</option>
                    {
                        venues &&
                        venues.map((venue, index) => (
                                <option key={index} value={venue.id}>{venue.name}</option>
                            
                    ))
                    }                
                </select>
                <br/>
                <label htmlFor="start_date">Start date:</label>
                <input type="date" name="start_date" id="start_date" onChange={saveInput}/>
                <br/>
                <label htmlFor="start_time">Start time:</label>
                <input type="time" name="start_time" id="start_time" onChange={saveInput}/>
                <br/>
                <label htmlFor="end_date">End date:</label>
                <input type="date" name="end_date" id="end_date" onChange={saveInput}/>
                <br/>
                <label htmlFor="end_time">End time:</label>
                <input type="time" name="end_time" id="end_time" onChange={saveInput}/>
                <br/>
                <label htmlFor="description">Descriptiom:</label>
                <textarea name="description" id="description" onChange={saveInput}></textarea>
                <br/>
                <label htmlFor="price">Price:</label>
                <input type="number" name="price" id="price" onChange={saveInput}/>
                <br/>
                    <CategorySelection
                        categories={categories}
                        selectedMainCategory={selectedMainCategory}
                        setSelectedMainCategory={setSelectedMainCategory}
                        />


                <br/>
                <label htmlFor="is_recurring">Do you want to create event that is recuring in time?</label>
                <input type="checkbox" name="is_recurring" id="is_recurring" value={input.is_recurring} onChange={saveCheckbox}/>
                <br/>
                {
                    days.map((day, index) => (
                        input.is_recurring == 1 ?
                        <div key={index}>
                        <label htmlFor="dayofweek">{day}</label>
                        <input className="dayofweek" type="checkbox" name={day} value={input[day]} onChange={saveCheckbox}/>
                        <br/>
                        </div>
                        :
                        ''

                    ))
                    
                }
                <button onClick={() => getChecked()}>Create event</button>

            </form>
        </div>
    )
}