import React from 'react'
import EventBus from 'eventing-bus'


const Logout = ()=> {

    EventBus.publish('removeToken')


    return (
        <h1>Logout</h1>
    )
}

export default Logout
