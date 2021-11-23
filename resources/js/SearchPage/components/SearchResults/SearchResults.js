import React, { useEffect } from 'react'

const SearchResults = ({ results: { event, group_choices } }) => {
    useEffect(() => {
        console.log(event)
    }, [event])
    return (
        event ?
            <>
                <h2> {event.name}</h2>
                <h4>Event match score: {group_choices[0].score}</h4>
                <p>Venue: {event.venue.name}</p>
                <p>{event.description}</p>
                <p>Starts at: {event.start_time}</p>
                <p>Ends at: {event.end_time}</p>
                <p>Address: {event.venue.address}</p>
                <a href={event.venue.website}>{event.venue.name}</a>
                {event.venue.map_link.includes('embed')
                    &&
                    <iframe
                        src={event.venue.map_link}
                        width="600"
                        height="450"
                        // style="border:0;"
                        allowFullScreen

                    // loading="lazy"
                    >
                    </iframe>
                }
            </> :
            <></>
    )
}

export default SearchResults
