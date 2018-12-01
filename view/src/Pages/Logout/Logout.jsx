import React from 'react'


const Logout = ()=> {

    if(localStorage.getItem('token') !== null)
    {
        localStorage.removeItem('token')
        localStorage.removeItem('user_id')
    }


    return (
        <h1>Logout</h1>
    )
}

export default Logout
