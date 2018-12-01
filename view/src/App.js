import React from 'react';
import { BrowserRouter as Router, Route, Redirect, Switch } from 'react-router-dom'
import EventBus from 'eventing-bus'


import { Home, Profiles, Match, MyProfile, Login, Logout, Register } from './Pages'
import { Container, Alert } from './Components'
import { isAuth, getToken, getUserId } from './services'


class App extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            alert: false,
            type: null,
            message: null,
            token: null,
            userId: null
        }
    }

    componentDidMount()
    {
        EventBus.on('triggerAlert', (payload)=> {
            this.setState({
                alert: true,
                type: payload.type,
                message: payload.message
            })
            setTimeout(()=> {
                this.setState({
                    alert: false,
                    type: null,
                    message: null
                })
            }, 5000)
        })

        EventBus.on('saveToken', (payload)=> {
            this.setState({
                token: payload.token,
                userId: payload.userId
            })
            localStorage.setItem('token', payload.token);
            localStorage.setItem('user_id', payload.userId);
        })
    }

    privateRoutes()
    {
        return (
            <Switch>
                <Route exact path="/" component={ Profiles } />
                <Route exact path="/me" component={ MyProfile } />
                <Route exact path="/matches" component={ Match } />
                <Route exact path="/logout" component={ Logout } />

                <Redirect to='/' />
            </Switch>
        )
    }

    publicRoutes()
    {
        return (
            <Switch>
                <Route exact path="/" component={ Home } />
                <Route exact path="/login" component={ Login } />
                <Route exact path="/register" component={ Register } />

                <Redirect to='/login' />
            </Switch>
        )
    }

    render()
    {
        return (
            <div>
                <Router>
                    <Container>
                        { this.state.token ? this.privateRoutes() : this.publicRoutes() }
                    </Container>
                </Router>

                <Alert show={ this.state.alert } type={ this.state.type }>
                    { this.state.message }
                </Alert>
            </div>
        )
    }
}

export default App;
