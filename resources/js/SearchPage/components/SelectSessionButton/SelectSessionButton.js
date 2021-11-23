import { Button } from '@mui/material'
import React from 'react'

const SelectSessionButton = ({ setPopupOpen }) => {
    return (

        <Button variant="contained" onClick={() => setPopupOpen(true)}>Select a different session
        </Button>
    )
}

export default SelectSessionButton
