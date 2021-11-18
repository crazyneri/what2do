
import React, { useEffect, useState } from 'react'
import DragAndDrop from '../DragAndDrop/DragAndDrop'
import Inputs from '../Inputs/Inputs'
import { get } from '../../../util/request';
import UserContext from '../../../util/UserContext';
import SoloOrGroupPopup from '../SoloOrGroupPopup/SoloOrGroupPopup';
import { DateTime } from 'luxon';



const App = () => {


    // input values

    const initialValues = {
        city: 'Prague',
        date: DateTime.now().toFormat('yyyy-MM-dd'),
        startTime: '12:00:00',
        endTime: '12:00:00',
    }

    const [values, setValues] = useState(initialValues)

    const { city, date, startTime, endTime } = values;

    // drag and drop states
    const [state, setState] = useState(null);
    const [showCinemaSubCats, setShowCinemaSubCats] = useState(false);
    const [showTheatreSubCats, setShowTheatreSubCats] = useState(false);
    const [showMusicSubCats, setShowMusicSubCats] = useState(false);
    const [columnsToRender, setColumnsToRender] = useState([]);

    const [searchIds, setSearchIds] = useState([]);


    useEffect(() => {
        console.log(values);
    })


    const search = () => {
        console.log(searchIds);
    }

    const [user, setUser] = useState(null);

    const [groupId, setGroupId] = useState(0);


    const fetchUser = async () => {

        const response = await get('/api/user');

        console.log(response.data);
        setUser(response.data);
    }

    useEffect(() => {
        fetchUser();
    }, [])

    // useEffect(() => {
    //     user && fetchUser();
    // }, [user.groups]);


    return (
        <>
            <UserContext.Provider value={user}>
                {(user && groupId === 0) &&
                    <SoloOrGroupPopup setGroupId={setGroupId} />
                }
                <Inputs
                    city={city}
                    date={date}
                    startTime={startTime}
                    endTime={endTime}
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
            </UserContext.Provider>
        </>
    )
}

export default App
