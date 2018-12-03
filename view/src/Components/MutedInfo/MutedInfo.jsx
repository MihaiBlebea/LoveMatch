import React from 'react'


const MutedInfo = (props)=> {
    return (
        <div className="w-75 mx-auto">
            <p className="text-muted text-center">{ props.children }</p>
        </div>
    )
}

export default MutedInfo
