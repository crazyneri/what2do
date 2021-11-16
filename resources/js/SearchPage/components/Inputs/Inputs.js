import React, { useState } from 'react'

const Inputs = () => {

    const [city, setCity] = useState('Prague')
    const [date, setDate] = useState('')
    const [time, setTime] = useState('')

    return (
        <div className='inputs'>
            <label htmlFor="city">Location:</label>
            <input type="text" name='city' value={city} />
            <label htmlFor="date">When:</label>
            <input type="date" name='date' value={date} />
            <label htmlFor="time">Duration:</label>
            <input type="time" name='time' value={time} />
        </div>
    )
}

export default Inputs
