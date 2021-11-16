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

    const empty = () => {
        return <EmptyRefinements />;
    };

    return (
        <div className={`column ${draggedOverClass}`} key={key}>
            <h2 style={{ borderBottom: '1px solid black' }}>{column.title}</h2>
            {column.columnType === 'sub' && (
                <button type="button" onClick={closeSubCats} className="refine">
                    close sub-categories
                </button>
            )}
            {column.id === 'empty-sub-categories' ? (
                empty()
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
