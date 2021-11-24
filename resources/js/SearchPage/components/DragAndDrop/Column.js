import React from 'react';
// import Task from './Category';
import { Droppable } from 'react-beautiful-dnd';
import { useEffect, useState } from 'react';
import CategoryBox from './CategoryBox';
import EmptyRefinements from './EmptyRefinements';

export default function Column({
    key,
    column,
    categories,
    showCinemaSubCats,
    setShowCinemaSubCats,
    showTheatreSubCats,
    setShowTheatreSubCats,
    showMusicSubCats,
    setShowMusicSubCats,
}) {
    const [beingDraggedOver, setBeingDraggedOver] = useState(false);
    const [draggedOverClass, setDraggedOverClass] = useState('');

    useEffect(() => {
        beingDraggedOver
            ? setDraggedOverClass('dragged-over')
            : setDraggedOverClass('');
    }, [beingDraggedOver]);

    const closeSubCats = () => {
        setShowCinemaSubCats(false);
        setShowMusicSubCats(false);
        setShowTheatreSubCats(false);
    };

    // const empty = () => {
    //     return <EmptyRefinements />;
    // };

    return (
        <div
            className={
                column.columnType !== 'sub'
                    ? `column ${draggedOverClass}`
                    : `column refinement-box ${draggedOverClass}`
            }
            // id={
            //     column.columnType === 'sub' && column.categoryId === 0
            //         ? 'refinement-box-1'
            //         : column.columnType === 'sub' && column.categoryId !== 0
            //         ? 'refinement-box-2'
            //         : ''
            // }
            key={key}
            onClick={column.columnType === 'sub' && closeSubCats}
        >
            <h2 id={column.columnType === 'sub' && 'refinement-box__title'}>
                {column.title}
            </h2>
            {/* {column.columnType === 'sub' && (
                <button
                    type="button"
                    onClick={closeSubCats}
                    className="refine close"
                >
                    close
                </button>
            )} */}
            {column.id === 'empty-sub-categories' ? (
                <EmptyRefinements />
            ) : (
                <Droppable
                    droppableId={column.id}
                    type={column.columnType === 'sub' ? 'sub' : 'main'}
                >
                    {(provided, snapshot) => (
                        <div
                            className="drag-space"
                            beingDraggedOver={setBeingDraggedOver(
                                snapshot.isDraggingOver
                            )}
                            ref={provided.innerRef}
                            {...provided.droppableProps}
                        >
                            {categories.map((category, i) => (
                                <CategoryBox
                                    key={category.id}
                                    category={category}
                                    index={i}
                                    showCinemaSubCats={showCinemaSubCats}
                                    setShowCinemaSubCats={setShowCinemaSubCats}
                                    showTheatreSubCats={showTheatreSubCats}
                                    setShowTheatreSubCats={
                                        setShowTheatreSubCats
                                    }
                                    showMusicSubCats={showMusicSubCats}
                                    setShowMusicSubCats={setShowMusicSubCats}
                                />
                            ))}
                            {provided.placeholder}
                        </div>
                    )}
                </Droppable>
            )}
        </div>
    );
}
