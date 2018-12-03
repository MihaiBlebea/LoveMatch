import React from 'react'
import { Link } from 'react-router-dom'
import { withRouter } from "react-router"


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
                                <Link to={ this.props.match.path + '/messages/' + user.id }>
                                    <MatchCard name={ user.name }
                                               gender={ user.gender }
                                               age={ user.birth_date.age }
                                               image={ user.images[0] ? user.images[0].path : null}/>
                                </Link>
                            </div>
                        )
                    }
                    return null
                })
            })
        }
        return (
            <div className="w-75 mx-auto">
                <p className="text-muted text-center">You don't have any matches yet</p>
            </div>
        )
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

export default withRouter(UserMatches)
