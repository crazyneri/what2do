import React, { useEffect, useState } from "react";
import DragAndDrop from "../DragAndDrop/DragAndDrop";
import Inputs from "../Inputs/Inputs";
import { get, post } from "../../../util/request";
import UserContext from "../../../util/UserContext";
import SoloOrGroupPopup from "../SoloOrGroupPopup/SoloOrGroupPopup";
import { DateTime } from "luxon";

const App = () => {
    // input values

    const initialValues = {
        city: "Prague",
        date: DateTime.now().toFormat("yyyy-MM-dd"),
        startTime: "12:00:00",
        endTime: "12:00:00",
    };

    const [values, setValues] = useState(initialValues);

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
    const [searchSession, setSearchSession] = useState(null);

    const nonAnonymousSearch = user && user.id !== 0 && searchSessionId === 0;

    const showPopup =
        (user && user.id !== 0 && searchSessionId === 0) ||
        (user && user.id === 0);
    // || (user && user.id === 0)

    const updateSession = async () => {
        const sessionData = {
            session_id: searchSessionId,
            searched_date: values.date,
            start_time: values.startTime,
            end_time: endTime,
        };
        try {
            const response = await post("/session/update", sessionData);

            console.log(response.data);
        } catch (error) {
            console.log(error.response);
        }
    };
    const sendSearchDetails = async () => {
        const searchDetailsData = {
            session_id: searchSessionId,
            user_id: user.id,
            category_ids: searchIds,
        };

        console.log(searchDetailsData);

        try {
            const response = await post(
                "/user-choice/store",
                searchDetailsData
            );

            console.log(response.data);
        } catch (error) {
            console.log(error.response);
        }
    };

    const search = () => {
        updateSession();
        sendSearchDetails();
        getSearchSessionDetails();
    };

    const fetchUser = async () => {
        const response = await get("/api/user");

        const u = await response.data;
        console.log("logged in user", u);

        setUser(u);

        !u && window.location.assign("/login");
    };

    useEffect(() => {
        fetchUser();
    }, []);

    const startSession = async (group_id) => {
        // setLoading(true)
        const sessionData = {
            user_id: user.id,
            group_id: group_id,
        };
        console.log("starting session with group id", group_id);

        try {
            const response = await post("/session/store", sessionData);

            const search_session_id = response.data;

            console.log("session started, id: ", search_session_id);

            setSearchSessionId(search_session_id);
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
                "/session/save-session-to-cookies",
                sessionData
            );

            console.log("session started, id: ", session_id);

            setSearchSessionId(session_id);
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    const getSearchSessionDetails = async () => {
        // setLoading(true)

        try {
            const response = await get("/api/session/details");

            const session_id = response.data.id;
            const group_id = response.data.group_id;
            setGroupId(group_id);
            console.log("session details: ", response.data);

            setSearchSession(response.data);

            setSearchSessionId(session_id);

            user && user.id === 0 && session_id === 0 && startSession(group_id);
        } catch (error) {
            console.log(error.response);
        }

        // setLoading(false);
    };

    useEffect(() => {
        getSearchSessionDetails();
    }, []);

    const alreadyResponded =
        user &&
        user.id &&
        searchSession &&
        searchSessionId !== 0 &&
        searchSession.user_choices &&
        searchSession.user_choices.some(
            (user_choice) => user_choice.user_id === user.id
        );

    console.log(alreadyResponded);

    return (
        <div className="search-grid">
            <UserContext.Provider value={user}>
                {nonAnonymousSearch && (
                    <SoloOrGroupPopup
                        groupId={groupId}
                        setGroupId={setGroupId}
                        startSession={startSession}
                        saveSessionToCookies={saveSessionToCookies}
                    />
                )}
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
                {!alreadyResponded && (
                    <div className="btn-search-container">
                        <button className="btn-search-results" onClick={search}>
                            Search
                        </button>
                    </div>
                )}
            </UserContext.Provider>
        </div>
    );
};

export default App;
