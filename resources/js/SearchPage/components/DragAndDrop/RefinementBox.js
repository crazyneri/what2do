import { useState, useEffect } from 'react';

export default function RefinementBox({ category, refinementBoxStyle }) {
    return category.categoryBoxOrder.map((categoryBoxId) => {
        // get each category's details from the props category values:
        // the category
        const box = category.categoryBoxes[categoryBoxId];
        //console.log({ box });
        // the refinements in the column
        const refinements = box.categoryIds.map(
            (refinementId) => category.refinements[refinementId]
        );
        //console.log({ refinements });

        // render the components:
        // don't forget the key so react can keep track
        // pass the column and the tasks

        return (
            <div className={refinementBoxStyle}>
                <h5>{box.title}</h5>
                {refinements.map((refinement, i) => (
                    <p>{refinement.name}</p>
                ))}
            </div>
        );
    });
}

//  <RefinementBox
//                 refinements={refinements}
//                 refinementBoxStyle={refinementBoxStyle}
//             />;
