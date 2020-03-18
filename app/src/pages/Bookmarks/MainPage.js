import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {UserList} from "./UserList";
import {userAction} from "../../shared/actions/user-action";

export const MainPage= () => {

    const users = useSelector(state => state.users);

    const dispatch = useDispatch();


    const effects = () => {
        dispatch(userAction())
    };

    const inputs = [];

    useEffect(effects, inputs);

    return (
        <main className="container">
            <table className="table table-responsive table-hover table-dark">
                <thead>
                <tr>
                    <th><h4>User Id</h4></th>
                    <th><h4>User Activation Token</h4></th>
                    <th><h4>User Age</h4></th>
                    <th><h4>User First Name</h4></th>
                    <th><h4>User Hash</h4></th>
                    <th><h4>User Last Name</h4></th>
                    <th><h4>User Phone</h4></th>

                </tr>
                </thead>
                <UserList users={users}/>
            </table>
        </main>
    )
};