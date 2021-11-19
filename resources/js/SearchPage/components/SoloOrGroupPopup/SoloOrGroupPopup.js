import React, { forwardRef, useContext, useEffect, useState } from 'react';
import UserContext from '../../../util/UserContext';
import './SoloOrGroupPopup.scss'
import Avatar from '@mui/material/Avatar';
import AvatarGroup from '@mui/material/AvatarGroup';
import { Autocomplete, List, ListItem, ListItemAvatar, ListItemButton, TextField, ListItemText, Typography, Button, Zoom, Divider, } from '@mui/material';

import { get, post } from '../../../util/request';

import { makeStyles } from '@mui/styles'

const SoloOrGroupPopup = forwardRef((props, ref) => {

    const user = useContext(UserContext);

    const [users, setUsers] = useState([]);

    const [groupMembers, setGroupMembers] = useState([]);

    const [groupName, setGroupName] = useState('');

    const useStyles = makeStyles({
        root: {
            flexDirection: 'column',
            alignItems: 'stretch !important',
            padding: '8px 0 !important',
        },
        avatars: {
            width: '20%'
        },
        avatarsGroup: {
            justifyContent: 'flex-end'
        }
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

        const array = [{
            id: user.id,
            name: user.name
        }, ...value
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
        <div className='popup-bg' {...props} ref={ref}>
            <Zoom in={(user && props.groupId === 0)}
                style={{
                    transitionDelay: (user && props.groupId === 0) ? '500ms' : '0ms',
                }}>
                <div className='popup'>
                    <h2>
                        Welcome back, {user.name}
                    </h2>
                    {!user.groups.length ?
                        <h3>
                            You are not in any group yet. Create a new one.
                        </h3>
                        :
                        <>
                            <h3>Groups you are in :</h3>
                            <Divider />
                            <List>
                                {user.groups.map(group =>
                                    <ListItem key={group.id} alignItems="flex-start" disablePadding divider className={classes.root}>
                                        <ListItemButton onClick={() => console.log('clicked')}>
                                            <ListItemAvatar className={classes.avatars}>
                                                <AvatarGroup className={classes.avatarsGroup} max={group.users.length > 2 ? group.users.length : 2}>
                                                    {group.users.map(user =>
                                                        <Avatar key={user.id} alt={user.name} src='/' />
                                                    )}
                                                </AvatarGroup>
                                            </ListItemAvatar>
                                            <ul className='users-list'>
                                                <ListItemText
                                                    primary={<>
                                                        <Typography
                                                            key={user.id}
                                                            sx={{ display: 'block', fontWeight: 'bold' }}
                                                            component="span"
                                                            variant="body2"
                                                            color="text.primary"
                                                        >{group.name}</Typography>
                                                    </>
                                                    }
                                                    secondary={
                                                        <>
                                                            <Typography
                                                                // key={user.id}
                                                                sx={{ display: 'inline', margin: '0 0.5rem' }}
                                                                component="span"
                                                                variant="body2"
                                                                color="text.primary"
                                                            >-YOU-</Typography>
                                                            {
                                                                group.users.filter((u) => u.id !== user.id)
                                                                    // group.users
                                                                    .map(user =>
                                                                        <Typography
                                                                            key={user.id}
                                                                            sx={{ display: 'inline', margin: '0 0.5rem' }}
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
                            </List >
                        </>
                    }
                    <h3>Create A New Group</h3>
                    <List>
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
                                        label="Search for friends"
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
                    <Button disabled={!(groupName && groupMembers.length)} variant="contained" onClick={launch}>{groupName && groupMembers.length ? 'Create the group and find out WHAT2DO !' : 'Add at least one friend and give the group a name !'}</Button>
                </div>
            </Zoom>
        </div >
    )
})

export default SoloOrGroupPopup
