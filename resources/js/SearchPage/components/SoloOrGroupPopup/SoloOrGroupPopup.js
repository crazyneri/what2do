import React, { useContext, useEffect, useState } from 'react';
import UserContext from '../../../util/UserContext';
import './SoloOrGroupPopup.scss'
import Avatar from '@mui/material/Avatar';
import AvatarGroup from '@mui/material/AvatarGroup';
import { Autocomplete, List, ListItem, ListItemAvatar, ListItemButton, TextField, ListItemText, Typography, Button, } from '@mui/material';

import { get, post } from '../../../util/request';

import { makeStyles } from '@mui/styles'

const SoloOrGroupPopup = () => {

    const user = useContext(UserContext);

    const [users, setUsers] = useState([]);

    const [groupMembers, setGroupMembers] = useState([]);

    const [groupName, setGroupName] = useState('');

    const useStyles = makeStyles({
        root: {
            flexDirection: 'column',
            alignItems: 'stretch !important',
            margin: '1.5rem 0'
        },
    });
    const classes = useStyles();

    const getUsers = async () => {

        const response = await get('/api/users');

        const allUsers = response.data;

        const otherUsers = allUsers.filter(u => u.id !== user.id)
        setUsers(otherUsers);
    }

    useEffect(() => {
        getUsers()
    }, []);

    const handleGroupName = (e) => {

        console.log(e.target.value);
        setGroupName(e.target.value);

    }


    const getGroupArray = (e, value) => {

        const array = [...value, {
            id: user.id,
            name: user.name
        }
        ];

        console.log(array);
        // console.log([...value]);

        setGroupMembers(array);

    }

    const createGroup = async () => {

        const groupData = {
            owner_id: user.id,
            groupMembers: groupMembers,
            groupName: groupName
        }

        console.log(groupData);
        try {

            const response = await post('/quick-create-group', groupData);
            console.log(response);
        } catch (error) {
            console.log(error.response)
        }

    }



    const startSession = async () => {

        const sessionData = {

        }

        const response = await post('/start-session', sessionData);
    }

    const launch = () => {
        createGroup();
        startSession();
    }


    return (
        <div className='popup-bg'>

            <div className='popup'>
                <h2>
                    Welcome back, {user.name}
                </h2>
                <h3>Groups you are in :</h3>
                {!user.groups.length ?
                    <p>
                        no groups
                    </p>
                    :
                    <List>
                        {user.groups.map(group =>

                            <ListItem key={group.id} alignItems="flex-start" disablePadding divider className={classes.root}>
                                <ListItemButton onClick={() => console.log('clicked')}>

                                    <ListItemAvatar>
                                        <AvatarGroup max={group.users.length > 2 ? group.users.length : 2}>
                                            {group.users.map(user =>
                                                <Avatar key={user.id} alt={user.name} src='/' />
                                            )}
                                        </AvatarGroup>
                                    </ListItemAvatar>
                                    <ul className='users-list'>
                                        <ListItemText
                                            primary={group.name}
                                            secondary={
                                                <>
                                                    {group.users.map(user =>
                                                        <Typography
                                                            key={user.id}
                                                            sx={{ display: 'inline' }}
                                                            component="span"
                                                            variant="body2"
                                                            color="text.primary"
                                                        >{user.name}</Typography>
                                                    )}
                                                </>
                                            }
                                        />
                                    </ul>
                                </ListItemButton>
                            </ListItem>

                        )
                        }
                        <h3>Create A New Group</h3>
                        <ListItem disablePadding divider
                            className={classes.root}
                        >
                            <Autocomplete
                                multiple
                                id="tags-outlined"
                                options={users}
                                getOptionLabel={(user) => user.name}
                                defaultValue={[]}
                                filterSelectedOptions
                                onChange={getGroupArray}
                                renderInput={(params) => (
                                    <TextField
                                        color='primary'
                                        {...params}
                                        label="Search for people"
                                        placeholder="Add more..."
                                    />
                                )}
                            />
                        </ListItem>
                        <ListItem className={classes.root}>
                            <TextField
                                required
                                color='primary'
                                label="Group Name"
                                onChange={handleGroupName}
                                value={groupName}
                            />
                        </ListItem>
                    </List >
                }
                <Button disabled={!(groupName && groupMembers.length)} variant="contained" onClick={launch}>{groupName && groupMembers.length ? 'Create' : 'The group must include people and have a name~'}</Button>
            </div>

        </div >
    )
}

export default SoloOrGroupPopup
