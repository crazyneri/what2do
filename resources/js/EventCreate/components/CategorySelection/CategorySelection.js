export default function CategorySelection({categories, subcategories, setSubcategories, selectedMainCategory, setSelectedMainCategory})
{

    return(
                <div className="dynamic_inputs">
                    <select name="category" value={selectedMainCategory} onChange={(e) => setSelectedMainCategory(e.target.value)}>
                        <option>-- select main category --</option>
                        {
                            categories &&
                            categories.map((category, index) => (
                                category.parent_id == 0 ?
                                    <option key={index} value={category.id}>{category.name}</option>
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
                                    <div key={index}>
                                    <label htmlFor="subcategory">{subcategory.name}</label>
                                    {!subcategories ?
                                    <input className="checkbox" name="subcategory" type="checkbox" value={subcategory.id}/>
                                    :
                                    <input className="checkbox" checked={subcategories && subcategories.includes(subcategory.id) ? true : false} name="subcategory" type="checkbox" 
                                        onChange={() => {
                                  
                                        if(subcategories && subcategories.includes(subcategory.id)){
                                            setSubcategories(subcategories.filter((s) => s !== subcategory.id))
                                        }else{
                                            setSubcategories([...subcategories, subcategory.id])                                            
                                        }
                                    }}
                                    value={subcategory.id}/>
                                    }
                                    </div>
                                    :
                                    ''
                            ))
                        }
                </div>
           
                
        
    )
}