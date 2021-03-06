import React from 'react'
import axios from 'axios'
import EventBus from 'eventing-bus'



class Login extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            email: '',
            password: ''
        }
    }

    handleInputChange(ev)
    {
        this.setState({
            [ev.target.name]: ev.target.value
        })
    }

    handleSubmitForm(ev)
    {
        ev.preventDefault()
        axios.post('/login', {
            email: this.state.email,
            password: this.state.password
        }).then((result)=> {
            if(result.status === 200)
            {
                // Trigger event bus to save the token into App component
                EventBus.publish('saveToken', { token: result.data.token, userId: result.data.user_id })
                // Redirect to home
                this.props.history.push('/')
            }
        }).catch((error)=> {
            console.log(error)
        })
    }

    render()
    {
        return (
            <div className="row justify-content-center" style={{ height: '80vh', overflowY: 'scroll' }}>
                <div className="col-md-6 pt-5 pb-5">
                    <h1>Login</h1>

                    <form>
                        <div className="form-group">
                            <label>Email address</label>
                            <input type="email"
                                   name="email"
                                   className="form-control"
                                   placeholder="Enter email"
                                   value={ this.state.email }
                                   onChange={ (ev)=> this.handleInputChange(ev) }/>
                        </div>
                        <div className="form-group">
                            <label>Password</label>
                            <input type="password"
                                   name="password"
                                   className="form-control"
                                   placeholder="Password"
                                   value={ this.state.password }
                                   onChange={ (ev)=> this.handleInputChange(ev) }/>
                        </div>
                        <button type="submit"
                                className="btn btn-primary"
                                onClick={ (ev)=> this.handleSubmitForm(ev) }>Submit</button>
                    </form>
                </div>
            </div>
        )
    }
}

export default Login
