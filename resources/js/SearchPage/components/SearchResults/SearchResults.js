import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

const SearchResults = ({
    // results: { event, group_choices }
    searchSession: { event },
}) => {
    const navigate = useNavigate();

    useEffect(() => {
        !event ? navigate('/search') : console.log(event);
    }, []);

    // if (!event) {
    //     return null
    // }

    return event ? (
        <>
            <h2>We have found you a match - now you know WHAT2DO!</h2>
            <h2> {event.name}</h2>
            {/* <h4>Event match score: {group_choices[0].score}</h4> */}
            <p>Venue: {event.venue.name}</p>
            <p>{event.description}</p>
            <p>Starts at: {event.start_time}</p>
            <p>Ends at: {event.end_time}</p>
            <p>Address: {event.venue.address}</p>
            <a href={event.venue.website}>{event.venue.name}</a>
            {event.venue.map_link.includes('embed') && (
                <iframe
                    src={event.venue.map_link}
                    width="600"
                    height="450"
                    // style="border:0;"
                    allowFullScreen

                    // loading="lazy"
                ></iframe>
            )}
        </>
    ) : (
        <></>
    );
};

export default SearchResults;
