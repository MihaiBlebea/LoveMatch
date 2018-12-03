import React from 'react'
import axios from 'axios'
import EventBus from 'eventing-bus'


import { UserCard, Loading } from './../../Components'
import { isAuth, getToken, getUserId } from './../../services'


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
        if(isAuth())
        {
            this.setState({
                token: getToken(),
                userId: getUserId()
            }, ()=> {
                this.getProfiles()
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
        EventBus.publish('toggleLoading')

        axios.post('/action', {
            type: type,
	        sender_id: this.state.userId,
	        receiver_id: profile.id
        }).then((result)=> {
            if(result.status === 200)
            {
                // Increment card index
                this.nextProfile()

                EventBus.publish('toggleLoading')
                
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

    render()
    {
        return (
            <div>
                { this.renderUserCard() }
            </div>
        )
    }
}

export default Profiles
