import React from 'react'

import { MatchCard } from './../index'



class UserMatches extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            matches: [],
            userId: null
        }
    }

    componentDidMount()
    {
        this.setState({
            matches: this.props.matches,
            userId: this.props.userId
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
                            <div className="border-bottom" key={ index }>
                                <MatchCard name={ user.name }
                                           gender={ user.gender }
                                           age={ user.birth_date.age }
                                           image={ user.images[0] ? user.images[0].path : null}/>
                            </div>
                        )
                    }
                    return null
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
