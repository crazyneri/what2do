import { useState, useEffect } from 'react';
import { DragDropContext } from 'react-beautiful-dnd';
import './style.scss';
import initialData from './initialData';
import Column from './Column';
import { get } from '../../../util/request';

function DragAndDrop() {
    const [state, setState] = useState(initialData);
    const [showCinemaSubCats, setShowCinemaSubCats] = useState(false);
    const [showTheatreSubCats, setShowTheatreSubCats] = useState(false);
    const [showMusicSubCats, setShowMusicSubCats] = useState(false);
    const [columnsToRender, setColumnsToRender] = useState([]);

    const [searchIds, setSearchIds] = useState([]);

    const renderColumns = () => {
        if (showCinemaSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return category === 'categories' || category.includes('cinema');
            });
            setColumnsToRender(columns);
        }
        if (showTheatreSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return (
                    category === 'categories' || category.includes('theater') || category.includes('theatre')
                );
            });
            setColumnsToRender(columns);
        }
        if (showMusicSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return category === 'categories' || category.includes('music');
            });
            setColumnsToRender(columns);
        }
        if (!showCinemaSubCats && !showMusicSubCats && !showTheatreSubCats) {
            const columns = state.columnOrder.filter((category) => {
                return (
                    category === 'categories' ||
                    category === 'what2do' ||
                    category === 'empty-sub-categories'
                );
            });
            setColumnsToRender(columns);
        }
    };

    useEffect(() => {
        renderColumns();
    }, [showCinemaSubCats, showTheatreSubCats, showMusicSubCats]);

    const onDragEnd = (result) => {
        // needs to update the state!
        const { destination, source, draggableId } = result;
        console.log(draggableId);
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
            console.log(newState);
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
            console.log(newState);

            setState(newState);
            // ? need to decide how to update the server
            // one way is to call an 'end-point' to let the server now a change has occurred
        }


    };

    useEffect(() => {

        const categoryIds = state.columns.what2do.categoryIds;
        const categoryNumberIds = categoryIds.map(categoryIds => {
            const categoryNumberId = state.categories[categoryIds].categoryId;
            return categoryNumberId;
        });

        setSearchIds(categoryNumberIds);

    }, [state]);



    const fetchData = async () => {

        const response = await get('/api/search');

        let categoriesObject = {};

        response.data.forEach((category) => {

            if (!categoriesObject[category.name.toLowerCase()]) {
                categoriesObject[category.name.toLowerCase()] = {
                    id: category.name.toLowerCase(),
                    name: category.name,
                    categoryId: category.id,
                    parent_id: category.parent_id,
                }
            }
        }

        );

        let columnsObject = {
            categories: {
                id: 'categories',
                title: 'Categories',
                columnType: 'main',
                categoryId: 0,
                categoryIds: response.data.filter((cat) => {
                    return cat.parent_id === 0;
                }).map(c => c.name.toLowerCase()),
            },
            what2do: {
                id: 'what2do',
                title: 'what2do',
                columnType: 'main',
                categoryId: 0,
                categoryIds: [],
            },
            'empty-sub-categories': {
                id: 'empty-sub-categories',
                title: 'Instructions:',
                columnType: 'main',
                categoryId: 0,
                categoryIds: [],
            },
        }

        response.data.forEach((category) => {
            const titleString = `${category.name} Preferences`;

            const preferencesString = `${category.name.toLowerCase()}-preferences`;


            const subcategoriesString = `${category.name.toLowerCase()}-sub-categories`;

            if (category.parent_id === 0) {
                columnsObject[preferencesString] = {
                    id: preferencesString,
                    title: titleString,
                    columnType: 'sub',
                    categoryId: category.id,
                    categoryIds: [],
                }



                columnsObject[subcategoriesString] = {
                    id: subcategoriesString,
                    title: titleString,
                    columnType: 'sub',
                    categoryId: category.id,
                    categoryIds:
                        response.data.filter((cat) => {
                            return cat.parent_id === category.id;
                        }).map(c => c.name.toLowerCase())
                    ,
                }

            }

        }

        );

        const initialState =

        {
            categories: categoriesObject,

            columns: columnsObject,

            // columnOrder: Object.keys(columnsObject)
            columnOrder: [
                'categories',
                'what2do',
                'cinema-preferences',
                'music-preferences',
                'theater-preferences',
                'cinema-sub-categories',
                'music-sub-categories',
                'theater-sub-categories',
                'empty-sub-categories',
            ]

        }
        setState(initialState);
    }
    useEffect(() => {


        fetchData();

    }, [])


    if (!state) {
        return <h1>loading</h1>
    }
    console.log(state);
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
