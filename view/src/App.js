import React from 'react';
import { BrowserRouter as Router, Route, Redirect, Switch } from 'react-router-dom'

import { Home, Profile, Match, Me, Login, Logout, Register } from './Pages'
import { Container } from './Components'
import { isAuth } from './services'


const App = ()=> {

    const privateRoutes = ()=> {
        return (
            <Switch>
                <Route exact path="/" component={ Profile } />
                <Route exact path="/me" component={ Me } />
                <Route exact path="/matches" component={ Match } />
                <Route exact path="/logout" component={ Logout } />

                <Redirect to='/' />
            </Switch>
        )
    }

    const publicRoutes = ()=> {
        return (
            <Switch>
                <Route exact path="/" component={ Home } />
                <Route exact path="/login" component={ Login } />
                <Route exact path="/register" component={ Register } />

                <Redirect to='/login' />
            </Switch>
        )
    }

    return (
        <Container>
            <Router>
                { isAuth() ? privateRoutes() : publicRoutes() }
            </Router>
        </Container>
    );
}

export default App;
