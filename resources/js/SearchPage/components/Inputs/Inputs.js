import React, { useEffect } from "react";

import { DateTime } from "luxon";

const Inputs = ({ values: { city, date, startTime, endTime }, setValues, searchSession }) => {

    // const { city, date, startTime, endTime } = values;


    const sessionStarted = searchSession && searchSession.status === 'started'


    const convertToHoursAndMinutes = (timeString) => {
        const formated = DateTime.fromFormat(timeString, "hh:mm").toFormat(
            "HH:mm:ss"
        );

        console.log(formated);

        return formated;
    };

    const handleChange = (e) => {
        const name = e.target.name;

        const inputValue = e.target.value;

        const valueToStore =
            name === "startTime" || name === "endTime"
                ? convertToHoursAndMinutes(inputValue)
                : inputValue;

        setValues((prev_values) => {
            return {
                ...prev_values,
                [name]: valueToStore,
            };
        });
    };

    const convertToObject = (timeString) => {
        const object = DateTime.fromFormat(timeString, "hh:mm:ss").toObject();

        // console.log(object);
        return object;
    };

    useEffect(() => {
        if (
            convertToObject(endTime).hour <= convertToObject(startTime).hour ||
            (convertToObject(endTime).hour ===
                convertToObject(startTime).hour &&
                convertToObject(endTime).minute <=
                convertToObject(startTime).minute)
        ) {
            setValues((prev_values) => {
                return {
                    ...prev_values,
                    endTime: "23:59:00",
                };
            });
        }
    }, [startTime, endTime]);

    return (
        <div className="inputs">
            <div className="inputs-item">
                <label htmlFor="city">Location:</label>
                <input
                    type="text"
                    name="city"
                    value={city}
                    onChange={handleChange}
                    disabled={sessionStarted}
                />
            </div>
            <div className="inputs-item">
                <label htmlFor="date">When:</label>
                <input
                    type="date"
                    name="date"
                    value={date}
                    onChange={handleChange}
                    disabled={sessionStarted}
                />
            </div>
            <div className="inputs-item">
                <label htmlFor="startTime">Start Time:</label>
                <input
                    type="time"
                    name="startTime"
                    value={startTime}
                    onChange={handleChange}
                    disabled={sessionStarted}
                />
            </div>
            <div className="inputs-item">
                <label htmlFor="endTime">End Time:</label>
                <input
                    type="time"
                    name="endTime"
                    value={endTime}
                    onChange={handleChange}
                    disabled={sessionStarted}
                />
            </div>
        </div>
    );
};

export default Inputs;
