import React, { useContext, useState, useEffect } from 'react';
import { Navigate, useNavigate } from 'react-router-dom';
import UserContext from '../../../util/UserContext';
import DragAndDrop from '../DragAndDrop/DragAndDrop';
import Inputs from '../Inputs/Inputs';

const SearchControls = ({
    values,
    setValues,
    state,
    setState,
    showCinemaSubCats,
    setShowCinemaSubCats,
    showTheatreSubCats,
    setShowTheatreSubCats,
    showMusicSubCats,
    setShowMusicSubCats,
    columnsToRender,
    setColumnsToRender,
    searchIds,
    setSearchIds,
    searchSession,
    searchSessionId,
    search,
    alreadyResponded,
    setAlreadyResponded,
}) => {
    const navigate = useNavigate();

    const user = useContext(UserContext);



    // useEffect(() => {
    // const responded =
    // user &&
    // user.id &&
    // searchSession &&
    // searchSession.id &&
    // searchSessionId !== 0 &&
    // searchSessionId === searchSession.id &&
    // searchSession.user_choices &&
    //     searchSession.user_choices.some(
    //         (user_choice) => user_choice.user_id === user.id
    //     );

    // console.log('already responded ?', responded);

    //     setAlreadyResponded(responded);
    // }, [searchSessionId]);

    // useEffect(() => {
    //     results && navigate("/search/results");
    // }, [results])

    return (
        <>
            <Inputs values={values} setValues={setValues} searchSession={searchSession} />
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
                searchSessionId={searchSessionId}
            />
            <div className="btn-search-container">
                {!alreadyResponded && searchIds && searchIds.length !== 0 ? (
                    <button
                        className="btn-search-results"
                        onClick={() => {
                            search();
                        }}
                    >
                        Search
                    </button>
                ) : (
                    <p className="btn-search-results btn-search-results--empty">
                        You must refine your categories to search!
                    </p>
                )}
            </div>
        </>
    );
};

export default SearchControls;
