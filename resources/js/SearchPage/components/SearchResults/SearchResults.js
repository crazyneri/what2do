import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import './SearchResults.scss';

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
        <div className="results">
            {event ? (
                <div className="results__container">
                    <h3 className="results__message">{message}</h3>
                    <h2 className="results__title"> {event.name}</h2>
                    <h4 className="results__score">
                        Event match score: {score}%
                    </h4>
                    <h4 className="results__score">
                        <span className="results__category">Venue:</span>{' '}
                        {event.venue.name}
                    </h4>
                    <p className="results__info">{event.description}</p>
                    <p className="results__info">
                        <span className="results__category">Date:</span>{' '}
                        {event.start_date}
                    </p>
                    <p className="results__info">
                        <span className="results__category">Starts at:</span>{' '}
                        {event.start_time}
                    </p>
                    <p className="results__info">
                        <span className="results__category">Ends at:</span>{' '}
                        {event.end_time}
                    </p>
                    <p className="results__info">
                        <span className="results__category">Address:</span>{' '}
                        {event.venue.address}
                    </p>
                    <a className="results__link" href={event.venue.website}>
                        {event.venue.name}
                    </a>
                    {event.venue.map_link.includes('embed') && (
                        <iframe
                            className="results__map"
                            src={event.venue.map_link}
                            width="500"
                            height="200"
                            // style="border:0;"
                            allowFullScreen

                            // loading="lazy"
                        ></iframe>
                    )}
                </div>
            ) : (
                <h3>{message}</h3>
            )}
        </div>
    );
};

export default SearchResults;
