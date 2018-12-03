import React from 'react'
import axios from 'axios'
import EventBus from 'eventing-bus'

import { UserCard, UserMatches } from './../../Components'
import { isAuth, getToken, getUserId } from './../../services'


class Profiles extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            profiles: [],
            matches: [],
            userId: null,
            token: null,
            cardIndex: 0
        }
    }

    componentDidMount()
    {
        if(isAuth())
        {
            this.setState({
                token: getToken(),
                userId: getUserId()
            }, ()=> {
                this.getProfiles()
                this.getMatches()
            })
        }
    }

    getProfiles()
    {
        axios.get('/users?count=20&user_id=' + this.state.userId + '&auth_token=' + this.state.token).then((profiles)=> {
            if(profiles.status === 200)
            {
                this.setState({
                    ...this.state,
                    profiles: profiles.data
                })
            }
        }).catch((error)=> {
            console.log(error)
        })
    }

    getMatches()
    {
        axios.get('/matches?user_id=' + this.state.userId).then((matches)=> {
            if(matches.status === 200)
            {
                this.setState({
                    matches: matches.data
                })
            }
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
                    // Trigger the notification that there is a new match
                    EventBus.publish('triggerAlert', { message: 'You have a new match', type: 'success' })
                    // Refresh the matches from the db
                    this.getMatches()
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
                          gender={ profile.gender }
                          description={ profile.description }
                          onLike={ ()=> this.handleAction(profile, 'like') }
                          onPass={ ()=> this.handleAction(profile, 'pass') }
                          onSeeProfile={ ()=> this.handleSeeProfile(profile) } />
            )
        }
        return null
    }

    renderUserMatches()
    {
        if(this.state.matches.length > 0)
        {
            return (
                <UserMatches matches={ this.state.matches }
                             userId={ this.state.userId }/>
            )
        }
        return null
    }

    render()
    {
        return (
            <div className="row justify-content-center" style={{ height: '80vh' }}>
                <div className="col-md-3 col-sm-8 border-right p-0 pt-5" style={{ overflowY: 'auto' }}>
                    { this.renderUserMatches() }
                </div>
                <div className="col-md-9 col-sm-8 h-100">
                    <div className="row justify-content-center align-self-center">
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
