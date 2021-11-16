import React, { useEffect, useState } from 'react'
import DragAndDrop from '../DragAndDrop/DragAndDrop'
import initialData from '../DragAndDrop/initialData';
import Inputs from '../Inputs/Inputs'

const App = () => {


    // input values

    const initialValues = {
        city: 'Prague',
        date: '',
        time: '',
    }

    const [values, setValues] = useState(initialValues)

    const { city, date, time } = values;

    // drag and drop states
    const [state, setState] = useState(initialData);
    const [showCinemaSubCats, setShowCinemaSubCats] = useState(false);
    const [showTheatreSubCats, setShowTheatreSubCats] = useState(false);
    const [showMusicSubCats, setShowMusicSubCats] = useState(false);
    const [columnsToRender, setColumnsToRender] = useState([]);

    const [searchIds, setSearchIds] = useState([]);


    useEffect(() => {
        console.log(values);
    }, [values])


    const search = () => {
        console.log(searchIds);
    }


    return (
        <>
            <Inputs
                city={city}
                date={date}
                time={time}
                setValues={setValues}
            />
            <DragAndDrop
                state={state}
                setState={setState}

                showCinemaSubCats={showCinemaSubCats}
                setShowCinemaSubCats={setShowCinemaSubCats}

                showTheatreSubCats={showTheatreSubCats}
                setShowTheatreSubCats={setShowTheatreSubCats}

                showMusicSubCats={showMusicSubCats}
                setShowMusicSubCats={setShowMusicSubCats}

                columnsToRender={columnsToRender}
                setColumnsToRender={setColumnsToRender}

                searchIds={searchIds}
                setSearchIds={setSearchIds}

            />
            <button onClick={search}>Search</button>
        </>
    )
}

export default App
