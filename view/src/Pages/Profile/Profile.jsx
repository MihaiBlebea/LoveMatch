import React from 'react'
import axios from 'axios'

import { UserCard } from './../../Components'


class Profile extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            profiles: [],
            userId: null,
            token: null
        }
    }

    componentDidMount()
    {
        if(this.isAuth())
        {
            this.setState({
                token: localStorage.getItem('token'),
                userId: localStorage.getItem('user_id')
            })
        }
    }

    isAuth()
    {
        if(localStorage.getItem('token'))
        {
            return true
        }
        return false
    }

    getProfiles()
    {
        axios.get('/users?count=20&user_id=' + this.state.userId + '&auth_token=' + this.state.token).then((profiles)=> {
            this.setState({
                ...this.state,
                profiles: profiles.data
            })
        }).catch((error)=> {
            console.log(error)
        })
    }

    handleAction(profile, type)
    {
        console.log(profile)
        axios.post('/action', {
            type: type,
	        sender_id: this.state.userId,
	        receiver_id: profile.id
        }).then((result)=> {
            if(result.status === 200)
            {

            }
            console.log(result.status)
        }).catch((error)=> {
            console.log(error)
        })
    }

    handleSeeProfile()
    {

    }

    renderUserCards()
    {
        if(this.state.profiles.length > 0)
        {
            return this.state.profiles.map((profile, index)=> {
                return (
                    <UserCard key={ index }
                              name={ profile.name }
                              images={ profile.images }
                              onLike={ ()=> this.handleAction(profile, 'like') }
                              onPass={ ()=> this.handleAction(profile, 'pass') }
                              onSeeProfile={ ()=> this.handleSeeProfile(profile) } />
                )
            })
        }
        return null
    }

    render()
    {
        if(this.state.token && this.state.userId && this.state.profiles.length === 0)
        {
            this.getProfiles()
        }

        return (
            <div>
                <h1>Profiles</h1>

                { this.renderUserCards() }
            </div>
        )
    }
}

export default Profile
