const isAuth = ()=> {
    if(localStorage.getItem('token'))
    {
        return true
    }
    return false
}

const getToken = ()=> {
    if(isAuth())
    {
        return localStorage.getItem('token')
    }
    return null
}

const getUserId = ()=> {
    if(isAuth())
    {
        return localStorage.getItem('user_id')
    }
    return null
}

const getLocation = (callback)=> {
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition((position)=> {
            callback(position)
        })
    }
    return null
}

export {
    isAuth,
    getToken,
    getUserId,
    getLocation
}
