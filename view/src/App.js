import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Redirect, Switch } from 'react-router-dom'

import { Home, Profile, Match } from './Pages'


class App extends Component
{
    isAuth()
    {
        return false;
    }

    privateRoutes()
    {
        return (
            <Switch>
                <Route path="/" component={ Home } />


                <Redirect to='/' />
            </Switch>
        )
    }

    publicRoutes()
    {
        return (
            <Switch>
                <Route exact path="/" component={ Home } />
                <Route exact path="/profiles" component={ Profile } />
                <Route exact path="/matches" component={ Match } />

                <Redirect to='/' />
            </Switch>
        )
    }

    render() {
        return (
            <div>
                <Router>
                    { this.isAuth() ? this.privateRoutes() : this.publicRoutes() }
                </Router>
            </div>
        );
    }
}

export default App;
