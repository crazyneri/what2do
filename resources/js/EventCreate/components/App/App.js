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
const [recurring, setRecurring] = useState('No');

// STATE FOR RECURRING DAYS
const [recDays, setRecDays] = useState(null);

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
        setRecurring('Yes')
    }else {
        setRecurring('No')
    }
}

// USE EFFECT
useEffect(() => {
    getData();
},[]);

// console.log(selectedMainCategory);
// console.log(selectedSubCategory);
// console.log(recurring);
// console.log(recDays);

    return(
        <div className="create-form">
            <form onSubmit={(e) => e.preventDefault()}>
                <label htmlFor="name">Name:</label>
                <input type="text" name="name" id="name"/>
                <br/>
                <label>Venue:</label>
                <select name="venue_id" onChange={(e) => console.log(e.target.value)}>
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
                <input type="date" name="start_date" id="start_date"/>
                <br/>
                <label htmlFor="start_time">Start time:</label>
                <input type="time" name="start_time" id="start_time"/>
                <br/>
                <label htmlFor="end_date">End date:</label>
                <input type="date" name="end_date" id="end_date"/>
                <br/>
                <label htmlFor="end_time">End time:</label>
                <input type="time" name="end_time" id="end_time"/>
                <br/>
                <label htmlFor="description">Descriptiom:</label>
                <textarea name="description" id="description"></textarea>
                <br/>
                <label htmlFor="price">Price:</label>
                <input type="number" name="price" id="price"/>
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
                        recurring == 'Yes' ?
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