import React from 'react'


const UserCard = (props)=> {
    return (
        <div className="card">
            <div className="card-body">
                <h4>{ props.name }</h4>
            </div>
        </div>
    )
}

export default UserCard
