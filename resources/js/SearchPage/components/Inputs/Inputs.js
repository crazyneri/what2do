import React from 'react'

const Inputs = ({ city, date, time, setValues }) => {

    const handleChange = (e) => {

        setValues(prev_values => {
            return ({
                ...prev_values,
                [e.target.name]: e.target.value
            });
        });
    }


    return (
        <div className='inputs'>
            <label htmlFor="city">Location:</label>
            <input type="text" name='city' value={city} onChange={handleChange} />
            <label htmlFor="date">When:</label>
            <input type="date" name='date' value={date} onChange={handleChange} />
            <label htmlFor="time">Duration:</label>
            <input type="time" name='time' value={time} onChange={handleChange} />
        </div>
    )
}

export default Inputs
