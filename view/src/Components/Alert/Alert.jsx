import React from 'react'


const Alert = (props)=> {

    let type
    switch(props.type)
    {
        case 'success':
            type = 'success'
            break
        case 'danger':
            type ='danger'
            break
        default:
            type = 'primary'
    }

    if(props.show)
    {
        return (
            <div className={ 'alert alert-' + type + ' position-absolute w-25 py-4' } role="alert" style={{ bottom: 0, right: 0 }}>
                { props.children }
            </div>
        )
    }
    return null
}

export default Alert
