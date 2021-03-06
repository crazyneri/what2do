import React, { useEffect, useState } from "react";
import { get, post } from "../../../util/request";
import UserContext from "../../../util/UserContext";
import SoloOrGroupPopup from "../SoloOrGroupPopup/SoloOrGroupPopup";
import { DateTime } from "luxon";
import { Routes, Route, useNavigate } from "react-router-dom";
import SearchControls from "../SearchControls/SearchControls";
import SearchResults from "../SearchResults/SearchResults";
import SessionControls from "../SessionControls/SessionControls";

const App = () => {
    // input values

    const initialValues = {
        city: 'Prague',
        date: DateTime.now().toFormat('yyyy-MM-dd'),
        startTime: '12:00:00',
        endTime: '12:00:00',
    };

    const [values, setValues] = useState(initialValues);

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
    const [searchSession, setSearchSession] = useState(null);

    const [results, setResults] = useState(null);

    const { startTime, endTime, city, date } = values;

    const [users, setUsers] = useState([]);

    const [groupMembers, setGroupMembers] = useState([]);

    const [groupName, setGroupName] = useState('');

    const nonAnonymousSearch = user && user.role !== 'anonymous';

    const [popupOpen, setPopupOpen] = useState(true);

    const [alreadyResponded, setAlreadyResponded] = useState(false);

    const navigate = useNavigate();



    const updateSession = async () => {
        const sessionData = {
            session_id: searchSessionId,
            searched_date: date,
            start_time: startTime,
            end_time: endTime,
            city: 'Prague',
        };
        try {
            const response = await post('/session/update', sessionData);

            console.log('session updated with data:', response.data);
        } catch (error) {
            console.log(error.response);
        }
    };
    const sendSearchDetails = async () => {
        // setLoading(true);
        const searchDetailsData = {
            session_id: searchSessionId,
            user_id: user.id,
            category_ids: searchIds,
        };

        console.log(searchDetailsData);

        try {
            const response = await post(
                '/user-choice/store',
                searchDetailsData
            );

            const results = response.data;

            console.log(results);

            setResults(results);

            getSearchSessionDetails();
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    const search = async () => {
        await updateSession();
        sendSearchDetails();
    };

    // useEffect(() => {
    //     getSearchSessionDetails();
    // }, [])

    const fetchUser = async () => {
        const response = await get('/api/user');

        const u = await response.data;
        console.log('logged in user', u);

        setUser(u);

        !u && window.location.assign('/login');
    };

    useEffect(() => {
        fetchUser();
    }, [searchSessionId]);

    const startSession = async (group_id) => {
        // setLoading(true)
        const sessionData = {
            user_id: user.id,
            group_id: group_id,
        };
        console.log('starting session with group id', group_id);

        try {
            const response = await post('/session/store', sessionData);

            const search_session_id = response.data;

            console.log('session started, id: ', search_session_id);

            setSearchSessionId(search_session_id);
            getSearchSessionDetails();
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    const saveSessionToCookies = async (session_id) => {
        // setLoading(true)
        const sessionData = {
            session_id: session_id,
        };

        try {
            const response = await post(
                '/session/save-session-to-cookies',
                sessionData
            );

            console.log('saving session to cookies: ', session_id);

            setSearchSessionId(session_id);
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    const getSearchSessionDetails = async () => {
        // setLoading(true)

        try {
            const response = await get('/api/session/details');

            const session_id = response.data.id;
            const group_id = response.data.group_id;
            setGroupId(group_id);
            console.log('session details: ', response.data);

            const session = response.data;

            setSearchSession(session);

            setSearchSessionId(session_id);

            // (await user &&
            //     user.id === 0 &&
            //     session_id === 0 &&
            //     startSession(group_id));

            console.log('navigate?', session, 'user choices', session.user_choices);

            // if (session && session.event_id && session.event_id !== null)
            if (session && session.user_choices.some(c => c.user_id === user.id)) {
                navigate('/search/results');
                setPopupOpen(false);
            }
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    useEffect(() => {
        getSearchSessionDetails();
    }, []);


    useEffect(() => {
        searchSessionId !== 0 && setValues({
            ...values,
            city: searchSession.city,
            date: searchSession.searched_date,
            start_time: searchSession.start_time,
            end_time: searchSession.end_time,
        })
    }, [searchSession])


    // setInterval to dynamically update the session every 5 seconds to show users the session has finished
    // useEffect(() => {
    //     setInterval(async () => {
    //         await getSearchSessionDetails();
    //         if (searchSession && searchSession.event_id && searchSession.event_id !== null) {
    //             navigate('/search/results');
    //         }
    //     }, 10000)

    // }, []);

    console.log(nonAnonymousSearch);

    useEffect(() => {
        if (!nonAnonymousSearch || searchSessionId !== 0) {
            console.log('anonymous, closing popup');
            setPopupOpen(false)
        }
        else {
            setPopupOpen(true)
        }
        // if (searchSessionId === 0) {
        //     setPopupOpen(true)
        // }
    }, [user, searchSessionId]);




    return (
        <div className="search-grid">
            <UserContext.Provider value={user}>
                {((user && popupOpen)) && (
                    <SoloOrGroupPopup
                        groupId={groupId}
                        setGroupId={setGroupId}
                        startSession={startSession}
                        saveSessionToCookies={saveSessionToCookies}
                        popupOpen={popupOpen}
                        setPopupOpen={setPopupOpen}
                        setSearchIds={setSearchIds}
                        setUsers={setUsers}
                        setGroupMembers={setGroupMembers}
                        setGroupName={setGroupName}
                        users={users}
                        groupMembers={groupMembers}
                        groupName={groupName}
                        getSearchSessionDetails={getSearchSessionDetails}
                        alreadyResponded={alreadyResponded}
                    />
                )}
                <SessionControls
                    setPopupOpen={setPopupOpen}
                    searchSession={searchSession}
                    groupMembers={groupMembers}
                />
                <Routes>
                    <Route
                        exact
                        path="/search/results"
                        element={

                            searchSession &&
                            <SearchResults
                                results={results}
                                searchSession={searchSession}
                            />
                        }
                    />

                    <Route
                        exact
                        path="/search"
                        element={
                            <SearchControls
                                values={values}
                                setValues={setValues}
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
                                searchSession={searchSession}
                                searchSessionId={searchSessionId}
                                search={search}
                                results={results}
                                alreadyResponded={alreadyResponded}
                                setAlreadyResponded={setAlreadyResponded}
                            />
                        }
                    ></Route>
                </Routes>
            </UserContext.Provider>
        </div>
    );
};

export default App;
