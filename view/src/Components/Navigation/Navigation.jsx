import React from 'react'
import { Link } from 'react-router-dom';

import './Navigation.css'



class Navigation extends React.Component
{
    render()
    {
        return (
            <nav className="nav">
                <Link className="nav-link active" to="/">Home</Link>
                <Link className="nav-link active" to="/me">Profile</Link>
                <Link className="nav-link active" to="/login">Login</Link>
                <Link className="nav-link active" to="/logout">Logout</Link>
            </nav>
        )
    }
}


export default Navigation
