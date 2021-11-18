import React, { useEffect } from 'react'

import { DateTime } from 'luxon';


const Inputs = ({ city, date, startTime, endTime, setValues }) => {

    const handleChange = (e) => {

        setValues(prev_values => {
            return ({
                ...prev_values,
                [e.target.name]: e.target.value

            });
        });

    }

    const convertToMilliseconds = (timeString) => {
        const timeInMilliseconds = DateTime.fromFormat(timeString, 'hh:mm').toObject();

        console.log(timeInMilliseconds);

        return timeInMilliseconds;
    }
    useEffect(() => {

        if (convertToMilliseconds(endTime) < convertToMilliseconds(startTime)) {
            setValues(prev_values => {
                return ({
                    ...prev_values,
                    endTime: startTime
                })

            });
        }
    }, [startTime, endTime])


    return (
        <div className='inputs'>
            <label htmlFor="city">Location:</label>
            <input type="text" name='city' value={city} onChange={handleChange} />
            <label htmlFor="date">When:</label>
            <input type="date" name='date' value={date} onChange={handleChange} />
            <label htmlFor="startTime">Start Time:</label>
            <input type="time" name='startTime' value={startTime} onChange={handleChange} />
            <label htmlFor="endTime">End Time:</label>
            <input type="time" name='endTime' value={endTime} onChange={handleChange} />
        </div>
    )
}

export default Inputs
