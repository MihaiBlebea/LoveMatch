import React from 'react'


const Logout = ()=> {

    if(localStorage.getItem('token') !== null)
    {
        console.log('ceva')
        localStorage.removeItem('token')
    }


    return (
        <h1>Logout</h1>
    )
}

export default Logout
