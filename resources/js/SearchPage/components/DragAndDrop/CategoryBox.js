import RefinementBox from './RefinementBox';
import { useState, useEffect } from 'react';
import { Draggable } from 'react-beautiful-dnd';

export default function CategoryBox({
    keyValue,
    category,
    index,
    showCinemaSubCats,
    setShowCinemaSubCats,
    showTheatreSubCats,
    setShowTheatreSubCats,
    showMusicSubCats,
    setShowMusicSubCats,
}) {
    const [beingDragged, setBeingDragged] = useState(false);
    const [draggingClass, setDraggingClass] = useState('list');

    useEffect(() => {
        beingDragged
            ? setDraggingClass('list dragging')
            : setDraggingClass('list');
    }, [beingDragged]);

    const showRefinements = () => {
        if (!showCinemaSubCats && category.id === 'cinema') {
            setShowCinemaSubCats(true);
        }
        if (showCinemaSubCats && category.id === 'cinema') {
            setShowCinemaSubCats(false);
        }
        if (
            !showTheatreSubCats &&
            (category.id === 'theater' || category.id === 'theatre')
        ) {
            setShowTheatreSubCats(true);
        }
        if (
            showTheatreSubCats &&
            (category.id === 'theater' || category.id === 'theatre')
        ) {
            setShowTheatreSubCats(false);
        }
        if (!showMusicSubCats && category.id === 'music') {
            setShowMusicSubCats(true);
        }
        if (showMusicSubCats && category.id === 'music') {
            setShowMusicSubCats(false);
        }
    };
    console.log({ showMusicSubCats });

    return (
        <Draggable
            // has two required props
            draggableId={category.id} // the unique id of that content
            index={index} // the index from the map that produces these elements
        >
            {(provided, snapshot) => (
                <div
                    onChange={setBeingDragged(snapshot.draggingOver)}
                    className={
                        category.parent_id === 0
                            ? `inner-column ${draggingClass}`
                            : `inner-column sub-category-box ${draggingClass}`
                    }
                    // we must apply the properties from 'provided to the
                    // draggable element
                    {...provided.draggableProps} // applied to the component that we want to move
                    ref={provided.innerRef}
                    key={index}
                    // onClick={showRefinements}
                    {...provided.dragHandleProps}
                >
                    <h3>{category.id}</h3>
                    {category.parent_id === 0 && (
                        <button
                            type="button"
                            onClick={showRefinements}
                            className="refine"
                        >
                            refine
                        </button>
                    )}
                </div>
            )}
        </Draggable>
    );
}
