import React from 'react'
import axios from 'axios'
import { Route, Switch } from 'react-router-dom'
import { Link } from 'react-router-dom'

import { UserMatches } from './../../Components'
import { Profiles } from './../index'
import { isAuth, getToken, getUserId } from './../../services'


class PrivateInterface extends React.Component
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

    isProfiles()
    {
        return this.props.match.path === '/main/profiles'
    }

    getLatestMatchUserId()
    {
        if(this.state.matches.length > 0)
        {
            return this.state.matches[0].users.map((user)=> {
                if(user.id !== this.state.userId)
                {
                    return user.id
                }
                return null
            })
        }
        return null
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
                <div className="col-md-3 col-sm-8 border-right p-0 pt-3" style={{ overflowY: 'auto' }}>

                    <div className="d-flex justify-content-center pb-5">
                        <div className="btn-group" role="group" aria-label="Basic example">
                            <Link to={ this.props.match.path + '/messages/' + this.getLatestMatchUserId() }
                                  className={ 'btn ' + (this.isProfiles() ? 'btn-outline-primary' : 'btn-primary') + ' btn-sm' }>
                                Messages
                            </Link>
                            <Link to={ this.props.match.path + '/profiles' }
                                  className={ 'btn ' + (!this.isProfiles() ? 'btn-outline-primary' : 'btn-primary') + ' btn-sm' }>
                                Matches
                            </Link>
                        </div>
                    </div>

                    { this.renderUserMatches() }
                </div>
                <div className="col-md-9 col-sm-8 h-100">
                    <div className="row justify-content-center align-self-center">
                        <div className="col-md-6">

                                <Switch>
                                    <Route path={ this.props.match.path + '/profiles' } component={ Profiles } />
                                    <Route path={ this.props.match.path + '/messages/:userId' } render={ (props)=> 'Messages' + props.match.params.userId } />
                                    <Route path={ this.props.match.path } component={ Profiles } />
                                </Switch>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default PrivateInterface
