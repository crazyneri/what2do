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
const [selectedSubCategory, setSelectedSubCategory] = useState(null);

// STATE FOR KEEPING INFO ABOUT RECURRING
const [recurring, setRecurring] = useState(0);

// STATE FOR RECURRING DAYS
const [recDays, setRecDays] = useState(null);

// STATE FOR REST INPUT
const [input, setInput] = useState({
    name: "",
    venue_id: "",
    start_date: "",
    start_time: "",
    end_date: "",
    end_time: "",
    description: "",
    price: ""
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
const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// GET VALUE OF CHECKBOXES - SUBCATEGORIES
const getChecked = () => {
    const checkboxes = document.querySelectorAll('.checkbox');
    const checkboxesDays = document.querySelectorAll('.dayofweek');
    const checked = [];
    const daysDB = []
    for(let i = 0; i < checkboxes.length; i++ ){
        if(checkboxes[i].checked == true){
            checked.push(checkboxes[i].value);
            setSelectedSubCategory(checked);
        }
    }
    for(let i = 0; i < checkboxesDays.length; i++){
        if(checkboxesDays[i].checked == true){
            daysDB.push(1);
        } else {
            daysDB.push(null);
        }
    }
    setRecDays(daysDB);   
}

// GET IF ITS RECCURING EVENT
const isRecurring = () => {
    const recurringCheckbox = document.querySelector('#question');
    if(recurringCheckbox.checked == true) {
        setRecurring(1)
    }else {
        setRecurring(0)
    }
}

// USE EFFECT
useEffect(() => {
    getData();
},[]);

// SEND THE DATA TO THE DB
const handleSubmit = async(event) => {
    event.preventDefault();

    let response = await axios.post('/admin/event/data', {input, selectedSubCategory, recurring, recDays}, {
        headers: {
                'Accept': 'application/json'
            }
    });
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

// console.log(selectedMainCategory);
// console.log(selectedSubCategory);
// console.log(recurring);
// console.log(recDays);
// console.log(input);

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
                <label htmlFor="question">Do you want to create event that is recuring in time?</label>
                <input type="checkbox" name="question" id="question" value={recurring} onClick={() => isRecurring()}/>
                <br/>
                {
                    days.map((day, index) => (
                        recurring == 1 ?
                        <div key={index}>
                        <label htmlFor="dayofweek">{day}</label>
                        <input className="dayofweek" type="checkbox" value={day}/>
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