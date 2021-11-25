import { Avatar, AvatarGroup, Button } from '@mui/material'
import React, { useContext } from 'react'
import UserContext from '../../../util/UserContext';

import './SessionControls.scss'

const SessionControls = ({ setPopupOpen, searchSession, groupMembers }) => {


    const handleClick = () => setPopupOpen(true)

    const user = useContext(UserContext);

    return (
        <div className='session-controls'>
            {searchSession && searchSession.group && searchSession.group.users.length !== 1 &&
                <>
                    <h5>{searchSession.group.name}</h5>
                    <AvatarGroup
                        // className={
                        //     classes.avatarsGroup
                        // }
                        max={
                            searchSession.group.users.length > 2
                                ? searchSession.group.users.length
                                : 2
                        }
                    >
                        {searchSession.group.users.map((user) => (
                            <Avatar
                                key={user.id}
                                alt={user.name}
                                src="/"
                            />
                        ))}
                    </AvatarGroup>
                    <p>{searchSession.user_choices.length}</p>
                    <p>/</p>
                    <p>{searchSession.group.users.length}</p>
                    {searchSession.user_choices.length === searchSession.group.users.length ? <p>the session has finished</p> : <p>waiting for others to respond</p>}
                </>
            }
            <Button variant="contained" onClick={handleClick}>Select a different session
            </Button>
        </div>
    )
}

export default SessionControls
