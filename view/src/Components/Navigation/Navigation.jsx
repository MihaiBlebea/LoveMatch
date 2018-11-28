import React from 'react'
import { Link, Router } from 'react-router-dom';


class Navigation extends React.Component
{
    render()
    {
        return (
            <nav class="nav">
                <a class="nav-link active" href="#">Active</a>
                <Link className="nav-link active"
                      to="/">Home</Link>
            </nav>
        )
    }
}


export default Navigation
