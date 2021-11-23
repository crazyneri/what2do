import { Avatar, AvatarGroup, Button } from '@mui/material'
import React, { useContext } from 'react'
import UserContext from '../../../util/UserContext';

import './SessionControls.scss'

const SessionControls = ({ setPopupOpen, searchSession, groupMembers }) => {

    const user = useContext(UserContext);

    return (
        <div className='session-controls'>
            {searchSession && searchSession.group && searchSession.group.users.length !== 1 &&
                <>
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
                </>
            }
            <Button variant="contained" onClick={() => setPopupOpen(true)}>Select a different session
            </Button>
        </div>
    )
}

export default SessionControls
