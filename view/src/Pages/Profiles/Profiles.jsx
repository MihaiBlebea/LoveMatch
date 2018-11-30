import React from 'react'
import axios from 'axios'
import EventBus from 'eventing-bus'


import { UserCard, UserMatches } from './../../Components'


class Profiles extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            profiles: [],
            userId: null,
            token: null,
            cardIndex: 0
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

    nextProfile()
    {
        let newCardIndex = this.state.cardIndex + 1
        if(newCardIndex < this.state.profiles.length)
        {
            this.setState({
                cardIndex: newCardIndex
            })
        }
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
                // Increment card index
                this.nextProfile()

                // See if the like spawned a match and trigger the alert event if so
                if(result.data.result !== undefined && result.data.result === 'Match found')
                {
                    EventBus.publish('triggerAlert', { message: 'You have a new match', type: 'success' })
                }
            }
        }).catch((error)=> {
            console.log(error)
        })
    }

    renderUserCard()
    {
        if(this.state.profiles.length > 0)
        {
            let profile = this.state.profiles[this.state.cardIndex]
            return (
                <UserCard name={ profile.name }
                          images={ profile.images }
                          age={ profile.birth_date.age }
                          description={ profile.description }
                          onLike={ ()=> this.handleAction(profile, 'like') }
                          onPass={ ()=> this.handleAction(profile, 'pass') }
                          onSeeProfile={ ()=> this.handleSeeProfile(profile) } />
            )
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
            <div className="row justify-content-center py-5" style={{ height: '80vh' }}>
                <div className="col-md-3 col-sm-8 border-right" style={{ overflowY: 'scroll' }}>
                    <UserMatches />
                </div>
                <div className="col-md-9 col-sm-8">
                    <div className="row justify-content-center">
                        <div className="col-md-6">
                            { this.renderUserCard() }
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Profiles
