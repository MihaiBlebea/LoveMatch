import React from 'react'

import './MatchCard.css'


const MatchCard = (props)=> {

    const getImage = ()=> {
        if(props.image)
        {
            return props.image
        }

        if(props.gender === 'FEMALE')
        {
            return 'https://www.w3schools.com/bootstrap4/img_avatar5.png'
        }
        return 'https://www.w3schools.com/bootstrap4/img_avatar1.png'
    }


    return (
        <div className="media p-2">
            <img className="align-self-center mr-3 w-25" src={ getImage() } alt="Generic" />
            <div className="media-body align-self-center">
                <h5 className="my-0">{ props.name }</h5>
                <p className="my-0 text-muted">{ props.age } years old</p>
            </div>
        </div>
    )
}

export default MatchCard
