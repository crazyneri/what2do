export default function EmptyRefinements() {
    return (
        <div className="drag-space">
            <p className="instructions-bold">
                Decide what you want to do - the closer to the top, the more you
                want to do it!
            </p>
            <ol>
                <li>
                    <span className="instructions-bold">Choose</span> the main
                    category.
                </li>
                <li>
                    <span className="instructions-bold">Drag</span> it into
                    'what2do'.
                </li>
                <li>
                    <span className="instructions-bold">Click</span> the refine
                    button.
                </li>
                <li>
                    <span className="instructions-bold">Choose</span> your
                    sub-categories.
                </li>
                <li>
                    <span className="instructions-bold">Close</span> the
                    sub-categories' when you have finished.
                </li>
                <li>
                    Press <span className="instructions-bold">search</span>!
                </li>
            </ol>
        </div>
    );
}
