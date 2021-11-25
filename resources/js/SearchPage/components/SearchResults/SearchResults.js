import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import './SearchResults.scss'

const SearchResults = ({
    // results: { event, group_choices }
    searchSession: { score, event, message },
}) => {
    const navigate = useNavigate();

    // useEffect(() => {
    //     !event ? navigate('/search') : console.log(event);
    // }, []);

    // if (!event || !score || !message) {
    //     return null
    // }


    return (
        <div className='results-container'>
            {event ?
                <>
                    <h3>{message}</h3>
                    <h2> {event.name}</h2>
                    <h4>Event match score: {score}%</h4>
                    <p>Venue: {event.venue.name}</p>
                    <p>{event.description}</p>
                    <p>Date: {event.start_date}</p>
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
                :
                <h3>{message}</h3>

            }
        </div>
    )
}

export default SearchResults;
