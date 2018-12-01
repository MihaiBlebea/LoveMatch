import React from 'react'
import axios from 'axios'

import { MatchCard } from './../index'
import { isAuth, getToken, getUserId } from './../../services'



class UserMatches extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            userId: null,
            matches: []
        }
    }

    componentDidMount()
    {
        if(isAuth())
        {
            let userId = getUserId()
            this.setState({
                userId: userId
            })
            this.getMatches(userId)
        }
    }

    getMatches(userId)
    {
        axios.get('/matches?user_id=' + userId).then((matches)=> {
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

    renderMatchCards()
    {
        if(this.state.matches.length > 0)
        {
            return this.state.matches.map((match, index)=> {
                return match.users.map((user)=> {
                    if(user.id !== this.state.userId)
                    {
                        return (
                            <div className="mb-2" key={ index }>
                                <MatchCard name={ user.name }
                                           gender={ user.gender }
                                           age={ user.birth_date.age }
                                           image={ user.images[0] ? user.images[0].path : null}/>
                            </div>
                        )
                    }
                })
            })
        }
        return null
    }

    render()
    {
        return (
            <div>
                <h4 className="text-center">Matches</h4>
                <hr />
                { this.renderMatchCards() }
            </div>
        )
    }
}

export default UserMatches
