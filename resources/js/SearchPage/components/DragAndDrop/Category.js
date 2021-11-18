import { useEffect, useState } from 'react';
import { Draggable } from 'react-beautiful-dnd';
import Refinement from './Refinement';
import CategoryBox from './CategoryBox';

export default function Category({ key, category, index }) {
    const [beingDragged, setBeingDragged] = useState(false);
    const [draggingClass, setDraggingClass] = useState('list');

    useEffect(() => {
        beingDragged
            ? setDraggingClass('list dragging')
            : setDraggingClass('list');
    }, [beingDragged]);
    // console.log(category.id);
    // console.log(category.refinements);
    // console.log(category.refinements.action);

    console.log({ category });

    return (
        <div
            style={{
                width: 'auto',
                height: 'auto',
                margin: '5%',
                padding: '10px',
                border: '1px solid black',
                borderRadius: '15px',
                fontFamily: 'sans-serif',
            }}
        >
            <h4>{category.id}</h4>
            {Object.values(category.categoryBoxes).map((box, i) => {
                <CategoryBox key={i} box={box} />;
            })}
        </div>
    );
}
