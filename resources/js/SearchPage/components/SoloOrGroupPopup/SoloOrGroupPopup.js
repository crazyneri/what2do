import React, { forwardRef, useContext, useEffect, useState } from "react";
import UserContext from "../../../util/UserContext";
import "./SoloOrGroupPopup.scss";
import Avatar from "@mui/material/Avatar";
import AvatarGroup from "@mui/material/AvatarGroup";
import {
    Autocomplete,
    List,
    ListItem,
    ListItemAvatar,
    TextField,
    ListItemText,
    Typography,
    Button,
    Zoom,
    Divider,
} from "@mui/material";


import { get, post } from "../../../util/request";

import { makeStyles } from "@mui/styles";
import { useNavigate } from "react-router-dom";

const SoloOrGroupPopup = forwardRef((props, ref) => {
    const user = useContext(UserContext);

    // const [users, setUsers] = useState([]);

    // const [groupMembers, setGroupMembers] = useState([]);

    // const [groupName, setGroupName] = useState("");

    const navigate = useNavigate();

    const useStyles = makeStyles({
        root: {
            flexDirection: "column",
            alignItems: "stretch !important",
            padding: "8px 0 !important",
        },
        avatars: {
            width: "20%",
        },
        avatarsGroup: {
            justifyContent: "flex-end",
        },
    });
    const classes = useStyles();

    const getUsers = async () => {
        const response = await get("/api/users");

        const allUsers = response.data;

        const otherUsers = allUsers.filter((u) => u.id !== user.id);
        props.setUsers(otherUsers);
    };

    useEffect(() => {
        getUsers();
    }, []);

    const handleGroupName = (e) => {
        props.setGroupName(e.target.value);
    };

    const getGroupArray = (e, value) => {
        const array = [
            {
                id: user.id,
                name: user.name,
            },
            ...value,
        ];

        props.setGroupMembers(array);
    };


    const createGroup = async () => {
        const groupData = {
            owner_id: user.id,
            groupMembers: props.groupMembers,
            groupName: props.groupName,
        };

        try {
            const response = await post("/quick-create-group", groupData);

            const res_group_id = response.data.group_id;

            await Promise.all([props.setGroupId(res_group_id),

            props.startSession(res_group_id)]);

            props.getSearchSessionDetails();

            props.setPopupOpen(false);
        } catch (error) {
            console.log(error.response);
        }
    };

    const createDefaultGroup = async () => {
        const groupData = {
            owner_id: user.id,
            groupMembers: [
                {
                    id: user.id,
                    name: user.name,
                },
            ],
            groupName: "Myself",
        };

        try {
            const response = await post("/quick-create-group", groupData);

            const res_group_id = response.data.group_id;

            const data = {
                user_id: user.id,
                default_group_id: res_group_id,
            };

            const default_group_response = await post(
                "/user/change-default-group",
                data
            );

            props.setGroupId(res_group_id);

            await props.startSession(res_group_id);

            props.getSearchSessionDetails();
        } catch (error) {
            console.log(error.response);
        }
    };

    const handleSoloSearch = async () => {
        if (user.default_group_id) {

            await startNewSession(user.default_group_id)
        }
        else {
            await createDefaultGroup();
        }
        props.setSearchIds([]);

        props.getSearchSessionDetails();

        props.setPopupOpen(false);
    };

    const startNewSession = async (groupId) => {
        await Promise.all(
            [props.setGroupId(groupId), props.startSession(groupId)]
        )
        // props.saveSessionToCookies(props.sessionId);
        props.setPopupOpen(false);

        navigate("/search")

    };



    const selectSession = async (groupId, session_id) => {
        props.setGroupId(groupId);

        await props.saveSessionToCookies(session_id);

        props.getSearchSessionDetails();
        props.setPopupOpen(false);

        navigate("/search")
    };

    return (
        <div className="popup-bg" ref={ref}>
            <Zoom
                in={true}
                style={{
                    transitionDelay:
                        user && props.groupId === 0 ? "500ms" : "0ms",
                }}
            >
                <div className="popup">
                    <h2>Welcome back, {user.name}</h2>
                    <Button
                        variant="contained"
                        onClick={() => handleSoloSearch()}
                    >
                        Find out WHAT2DO for yourself ! (solo search only)
                    </Button>

                    {user.groups.length <= 1 ? (
                        <h3>You are not in any group yet. Create a new one.</h3>
                    ) : (
                        <>
                            <h3>Select the group: </h3>
                            <Divider />
                            <List>
                                {user.groups
                                    .filter(
                                        (group) =>
                                            group.id !== user.default_group_id
                                    )
                                    .map((group) => (
                                        <ListItem
                                            key={group.id}
                                            alignItems="flex-start"
                                            disablePadding
                                            divider
                                            className={classes.root}
                                        >
                                            <ListItemAvatar
                                                className={classes.avatars}
                                            >
                                                <AvatarGroup
                                                    className={
                                                        classes.avatarsGroup
                                                    }
                                                    max={
                                                        group.users.length > 2
                                                            ? group.users.length
                                                            : 2
                                                    }
                                                >
                                                    {group.users.map((user) => (
                                                        <Avatar
                                                            key={user.id}
                                                            alt={user.name}
                                                            src="/"
                                                        />
                                                    ))}
                                                </AvatarGroup>
                                            </ListItemAvatar>
                                            <ul className="users-list">
                                                <ListItemText
                                                    primary={
                                                        <>
                                                            <Typography
                                                                key={user.id}
                                                                sx={{
                                                                    display:
                                                                        "block",
                                                                    fontWeight:
                                                                        "bold",
                                                                }}
                                                                component="span"
                                                                variant="body2"
                                                                color="text.primary"
                                                            >
                                                                {group.name}
                                                            </Typography>
                                                        </>
                                                    }
                                                    secondary={
                                                        <>
                                                            <Typography
                                                                // key={user.id}
                                                                sx={{
                                                                    display:
                                                                        "inline",
                                                                    margin: "0 0.5rem",
                                                                }}
                                                                component="span"
                                                                variant="body2"
                                                                color="text.primary"
                                                            >
                                                                -YOU-
                                                            </Typography>
                                                            {group.users
                                                                .filter(
                                                                    (u) =>
                                                                        u.id !==
                                                                        user.id
                                                                )
                                                                // group.users
                                                                .map((user) => (
                                                                    <Typography
                                                                        key={
                                                                            user.id
                                                                        }
                                                                        sx={{
                                                                            display:
                                                                                "inline",
                                                                            margin: "0 0.5rem",
                                                                        }}
                                                                        component="span"
                                                                        variant="body2"
                                                                        color="text.primary"
                                                                    >
                                                                        {
                                                                            user.name
                                                                        }
                                                                    </Typography>
                                                                ))}
                                                        </>
                                                    }
                                                />
                                            </ul>
                                            {group.search_sessions &&
                                                group.search_sessions
                                                    .length && (
                                                    <List>
                                                        <ListItem
                                                            disablePadding
                                                            className={
                                                                classes.root
                                                            }
                                                        >
                                                            <Button
                                                                variant="contained"
                                                                onClick={() =>
                                                                    startNewSession(
                                                                        group.id
                                                                    )
                                                                }
                                                            >
                                                                Start new
                                                                session
                                                            </Button>
                                                        </ListItem>
                                                        {group.search_sessions
                                                            .sort()
                                                            .map((session) => (
                                                                <ListItem
                                                                    key={
                                                                        session.id
                                                                    }
                                                                    disablePadding
                                                                    className={
                                                                        classes.root
                                                                    }
                                                                >
                                                                    <Button
                                                                        variant="contained"
                                                                        onClick={() =>
                                                                            selectSession(
                                                                                group.id,
                                                                                session.id
                                                                            )
                                                                        }
                                                                    >
                                                                        Session
                                                                        id:{" "}
                                                                        {
                                                                            session.id
                                                                        }
                                                                    </Button>
                                                                </ListItem>
                                                            ))}
                                                    </List>
                                                )}
                                        </ListItem>
                                    ))}
                            </List>
                        </>
                    )}
                    <h3>Create A New Group</h3>
                    <List>
                        <ListItem
                            disablePadding
                            divider
                            className={classes.root}
                        >
                            <Autocomplete
                                multiple
                                id="tags-outlined"
                                options={props.users}
                                getOptionLabel={(user) => user.name}
                                defaultValue={[]}
                                filterSelectedOptions
                                onChange={getGroupArray}
                                renderInput={(params) => (
                                    <TextField
                                        color="primary"
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
                                color="primary"
                                label="Group Name"
                                onChange={handleGroupName}
                                value={props.groupName}
                            />
                        </ListItem>
                    </List>
                    <Button
                        disabled={!(props.groupName && props.groupMembers.length)}
                        variant="contained"
                        onClick={createGroup}
                    >
                        {props.groupName && props.groupMembers.length
                            ? "Create the group and find out WHAT2DO !"
                            : "Add at least one friend and give the group a name !"}
                    </Button>
                </div>
            </Zoom>
        </div>
    );
});

export default SoloOrGroupPopup;
