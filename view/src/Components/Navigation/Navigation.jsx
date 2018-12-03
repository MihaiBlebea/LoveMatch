import React from 'react'
import { Link } from 'react-router-dom';

import './Navigation.css'

import { isAuth } from './../../services'


class Navigation extends React.Component
{
    renderPublicLinks()
    {
        return (
            <React.Fragment>
                <Link className="nav-link active" to="/login">Login</Link>
            </React.Fragment>
        )
    }

    renderPrivateLinks()
    {
        return (
            <React.Fragment>
                <Link className="nav-link active" to="/me">Profile</Link>
                <Link className="nav-link active" to="/logout">Logout</Link>
                <Link className="nav-link active" to="/messages">Messages</Link>
            </React.Fragment>
        )
    }

    render()
    {
        return (
            <nav className="nav">
                <Link className="nav-link active" to="/">Home</Link>
                { isAuth() ? this.renderPrivateLinks() : this.renderPublicLinks() }
            </nav>
        )
    }
}


export default Navigation
