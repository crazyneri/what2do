export default function EmptyRefinements() {
    return (
        <div className="drag-space">
            <ol>
                <li>
                    <span className="instructions-bold">Choose</span> what you
                    would like to do from the categories column.
                </li>
                <li>
                    <span className="instructions-bold">Drag</span> your chosen
                    activity into the 'what2do' column.
                </li>
                <li>
                    <span className="instructions-bold">Refine</span> your
                    search by clicking on the 'refine' button under the category
                    name.
                </li>
                <li>
                    <span className="instructions-bold">Drag</span> any
                    sub-categories you would like into the 'chosen
                    sub-categories' column in the centre.
                </li>
                <li>
                    <span className="instructions-bold">Press</span> the close
                    sub-categories' button when you have finished.
                </li>
                <li>
                    When you have decided what to do - press{" "}
                    <span className="instructions-bold">search</span>!
                </li>
            </ol>
        </div>
    );
}
