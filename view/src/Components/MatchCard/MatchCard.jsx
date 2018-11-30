import React from 'react'


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
        <div className="media">
            <div style={{ width: '100px' }}>
                <img className="align-self-start mr-3 w-100" src={ getImage() } alt="Generic" />
            </div>
            <div className="media-body ml-3">
                <h5 className="mt-0">{ props.name }</h5>
                <p>{ props.age } years old</p>
            </div>
        </div>
    )
}

export default MatchCard
