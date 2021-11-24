import React, { useEffect } from 'react';

const SearchResults = ({
    score,
    group_choices,
    event,
    venue,
    status,
    message,
}) => {
    // useEffect(() => {
    //     console.log(event);
    // }, [event]);
    return event ? (
        <>
            <h2> {event.name}</h2>
            <h4>Event match score: {score}%</h4>
            {/* <p>Venue: {venue.name}</p>
            <p>{event.description}</p>
            <p>Starts at: {event.start_time}</p>
            <p>Ends at: {event.end_time}</p>
            <p>Address: {venue.address}</p>
            <a href={venue.website}>{venue.name}</a> */}
            {/* {venue.map_link.includes('embed') && (
                <iframe
                    src={venue.map_link}
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                ></iframe>
            )} */}
        </>
    ) : (
        <></>
    );
};

export default SearchResults;
