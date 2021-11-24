import { useEffect } from "react";
import { DragDropContext } from "react-beautiful-dnd";
// import './style.scss';
import Column from "./Column";
import { get } from "../../../util/request";
import { RotateSpinner } from "react-spinners-kit";

function DragAndDrop({
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
    searchSessionId
}) {
    const renderColumns = () => {
        if (showCinemaSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return category === "categories" || category.includes("cinema");
            });
            setColumnsToRender(columns);
        }
        if (showTheatreSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return (
                    category === "categories" ||
                    category.includes("theater") ||
                    category.includes("theatre")
                );
            });
            setColumnsToRender(columns);
        }
        if (showMusicSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return category === "categories" || category.includes("music");
            });
            setColumnsToRender(columns);
        }
        if (!showCinemaSubCats && !showMusicSubCats && !showTheatreSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return (
                    category === "categories" ||
                    category === "what2do" ||
                    category === "empty-sub-categories"
                );
            });
            setColumnsToRender(columns);
        }
    };

    useEffect(() => {
        state && renderColumns();
    }, [showCinemaSubCats, showTheatreSubCats, showMusicSubCats, state]);

    const onDragEnd = (result) => {
        // needs to update the state!
        const { destination, source, draggableId } = result;
        // if there's no destination then there's nothing we need to do
        if (!destination) {
            return;
        }
        // if nothing changed we don't need to do anything
        if (
            destination.droppableId === source.droppableId &&
            destination.index === source.index
        ) {
            return;
        }
        // now get the column info from the state using the
        // info from the source
        const startColumn = state.columns[source.droppableId];
        const finishColumn = state.columns[destination.droppableId];
        // if the columns don't change
        if (startColumn === finishColumn) {
            // create a new array from the categoryIds - avoid mutating
            // the existing array
            const newCategoryIds = Array.from(startColumn.categoryIds);
            // move the taskId to the new index in the array
            // remove the source index from the array
            // (because we want to put it somewhere else in the array!)

            newCategoryIds.splice(source.index, 1);
            // add the destination index into the array (without deleting anything)
            // into the position recorded by the destination.index
            newCategoryIds.splice(destination.index, 0, draggableId);
            // create a new column with the same properties as the existing column
            // but with the updated task array properties

            const newColumn = {
                ...startColumn,
                categoryIds: newCategoryIds,
            };

            // add the new column into a new picture of the state
            // use object spread to keep the old properties of the state
            // but invalidate the references that we want to change
            const newState = {
                ...state,
                columns: {
                    ...state.columns,
                    [newColumn.id]: newColumn,
                },
            };
            // now update the state with the newState
            setState(newState);
        }

        if (startColumn !== finishColumn) {
            // to change between columns
            // create a new task ids array
            const startTasksIds = Array.from(startColumn.categoryIds);
            // remove the dragged task id from the array
            startTasksIds.splice(source.index, 1);
            // create a new start column with the same properties as
            // the old column but with the new startTasksIds array
            const newStartColumn = {
                ...startColumn,
                categoryIds: startTasksIds,
            };
            // create a new finish task ids array with the values
            // from the old one
            const finishCategoryIds = Array.from(finishColumn.categoryIds);
            // add the new task to the array using splice
            finishCategoryIds.splice(destination.index, 0, draggableId);
            // create new finish column
            const newFinishColumn = {
                ...finishColumn,
                categoryIds: finishCategoryIds,
            };
            // create new state object with the updated columns maps
            const newState = {
                ...state,
                columns: {
                    ...state.columns,
                    [newStartColumn.id]: newStartColumn,
                    [newFinishColumn.id]: newFinishColumn,
                },
            };

            setState(newState);
            // ? need to decide how to update the server
            // one way is to call an 'end-point' to let the server now a change has occurred
        }
    };

    const updatePreferences = () => {
        // finding selected category ids (string names of the category)
        const categoryIds = state.columns.what2do.categoryIds;

        let preferencesIds = [];

        categoryIds.forEach((categoryId) => {
            const preferencesString = `${categoryId}-preferences`;
            // finding the corresponding items in state.columns array under category-preferences key and retrieving its categoryIds array (still in string/name format)

            const subcategoriesArray =
                state.columns[preferencesString].categoryIds;
            // pushing the result to an array that then contains all preferences, i.e. subcategories chosen by the user under any main category (still in string/name format)
            preferencesIds.push(...subcategoriesArray);
        });

        // finding the corresponding unique keys of the subcategoriesArray items in state.categories object and creating a matching array containing those keys
        const categoryNumberIds = preferencesIds.map((preferenceId) => {
            const categoryNumberId = state.categories[preferenceId].categoryId;
            return categoryNumberId;
        });

        // updating the searchIds state array to reflect the current user preferences
        setSearchIds(categoryNumberIds);
    };

    useEffect(() => {
        // on state update (and once the data has been loaded, i.e. state is not null), we need to update state variable searchIds = array which includes preferences,i.e. subcategories chosen by the user - this array is to be used once the user clicks on the search button
        if (state) {
            updatePreferences();
        }
    }, [state]);

    const fetchData = async () => {
        const response = await get("/api/search");

        console.log(response.data);
        setState(response.data);
    };
    useEffect(() => {
        // on page reload, fetch categories data from database to populate the DragAndDrop component
        fetchData();
        setShowCinemaSubCats(false);
        setShowMusicSubCats(false);
        setShowTheatreSubCats(false)
    }, [searchSessionId]);

    if (!state) {
        return <RotateSpinner />;
    }

    return (
        <DragDropContext
            // see notes on this
            onDragEnd={onDragEnd}
        >
            <div className="container">
                {columnsToRender.map((columnId, key) => {
                    const column = state.columns[columnId];
                    const categories = column.categoryIds.map(
                        (categoryId) => state.categories[categoryId]
                    );
                    return (
                        <Column
                            key={columnId}
                            column={column}
                            categories={categories}
                            index={key}
                            showCinemaSubCats={showCinemaSubCats}
                            setShowCinemaSubCats={setShowCinemaSubCats}
                            showTheatreSubCats={showTheatreSubCats}
                            setShowTheatreSubCats={setShowTheatreSubCats}
                            showMusicSubCats={showMusicSubCats}
                            setShowMusicSubCats={setShowMusicSubCats}
                        />
                    );
                })}
            </div>
        </DragDropContext>
    );
}

export default DragAndDrop;
