
import React, { useEffect, useState } from 'react'
import DragAndDrop from '../DragAndDrop/DragAndDrop'
import Inputs from '../Inputs/Inputs'
import { get, post } from '../../../util/request';
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

    const [user, setUser] = useState(null);

    const [groupId, setGroupId] = useState(0);
    const [searchSessionId, setSearchSessionId] = useState(0);

    useEffect(() => {
        console.log(values);
    })


    const updateSession = async () => {

        const sessionData = {

            session_id: searchSessionId,
            searched_date: values.date,
            start_time: values.startTime,
            end_time: endTime
        }
        try {
            const response = await post('/session/update', sessionData);

            console.log(response.data);

        } catch (error) {
            console.log(error.response.message)
        }


    }
    const sendSearchDetails = async () => {

        const searchDetailsData = {
            session_id: searchSessionId,
            user_id: user.id,
            category_ids: searchIds,
        };

        try {
            const response = await post('/user-choice/store', searchDetailsData);

            console.log(response.data);

        } catch (error) {
            console.log(error.response.message)
        }


    }

    const search = () => {
        updateSession();
        sendSearchDetails();
    }



    const fetchUser = async () => {

        const response = await get('/api/user');

        console.log('logged in user', response.data);
        setUser(response.data);
    }

    useEffect(() => {
        fetchUser();
    }, [])

    // useEffect(() => {
    //     user && fetchUser();
    // }, [user.groups]);


    const startSession = async (group_id) => {

        // setLoading(true)
        const sessionData = {
            user_id: user.id,
            group_id: group_id,
        }
        console.log('starting session with group id', group_id)

        try {
            const response = await post('/session/store', sessionData);

            const search_session_id = response.data;

            setSearchSessionId(search_session_id);

        } catch (error) {
            console.log(error.response)
        }

        // setLoading(false);
    }


    const getSearchSessionDetails = async () => {

        // setLoading(true)

        try {
            const response = await get('/api/session/details');

            const search_session_id = response.data.search_session_id;
            const group_id = response.data.group_id;
            setGroupId(group_id);
            console.log('session details: ', response.data);


            setSearchSessionId(search_session_id);


        } catch (error) {
            console.log(error.response)
        }

        // setLoading(false);
    }

    useEffect(() => {
        getSearchSessionDetails();
    }, [])


    return (
        <>
            <UserContext.Provider value={user}>
                {(user && searchSessionId === 0) &&
                    <SoloOrGroupPopup groupId={groupId} setGroupId={setGroupId} startSession={startSession} />
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
