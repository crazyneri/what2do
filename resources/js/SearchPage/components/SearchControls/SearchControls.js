import React, { useContext } from 'react'
import UserContext from '../../../util/UserContext';
import DragAndDrop from '../DragAndDrop/DragAndDrop';
import Inputs from '../Inputs/Inputs';

const SearchControls = (
    { values,
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
        search }
) => {

    const user = useContext(UserContext);

    const alreadyResponded = user && user.id && searchSession && searchSessionId !== 0 && searchSession.user_choices && searchSession.user_choices.some(user_choice => user_choice.user_id === user.id)

    return (
        <>
            <Inputs
                values={values}
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
            {
                (!alreadyResponded && searchIds && searchIds.length !== 0) &&
                <button onClick={search}>Search</button>
            }
        </>
    )
}

export default SearchControls
