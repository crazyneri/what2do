export default function CategorySelection({categories, selectedMainCategory, setSelectedMainCategory})
{

    return(
                <div className="dynamic_inputs">
                    <select name="category" onChange={(e) => setSelectedMainCategory(e.target.value)}>
                        <option>-- select main category --</option>
                        {
                            categories &&
                            categories.map((category, index) => (
                                category.parent_id == 0 ?
                                    <option value={category.id}>{category.name}</option>
                                    :
                                    ''
                            ))
                        }
                    </select>
                    <br/>
                        {
                            categories &&
                            categories.map((subcategory, index) => (
                                subcategory.parent_id == selectedMainCategory && selectedMainCategory !== '' ?
                                    <>
                                    <label key={index} htmlFor="subcategory">{subcategory.name}</label>
                                    <input className="checkbox" type="checkbox" value={subcategory.id}/>
                                    <br/>
                                    </>
                                    :
                                    ''
                            ))
                        }
                </div>
           
                
        
    )
}