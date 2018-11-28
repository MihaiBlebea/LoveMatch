import React from 'react'
import axios from 'axios'

import { getLocation } from './../../services'


class Register extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            name: '',
            gender: '',
            birthdate: '',
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
        axios.post('/register', {
            name: this.state.name,
            gender: this.state.gender,
            birth_date: this.state.birthdate,
            email: this.state.email,
            password: this.state.password,
            longitude: '26.0835',
            latitude: '44.5672'
        }).then((result)=> {
            if(result.status === 200)
            {
                console.log(result)
            }
        }).catch((error)=> {
            console.log(error)
        })
    }

    render()
    {
        return (
            <div>
                <h1>Register</h1>

                <form>
                    <div className="form-group">
                        <label>Name</label>
                        <input type="text"
                               name="name"
                               className="form-control"
                               placeholder="Enter email"
                               value={ this.state.name }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                    <div className="form-group">
                        <label>Birthdate</label>
                        <input type="text"
                               name="birthdate"
                               className="form-control"
                               placeholder="Enter birthdate ( ex: 1989-11-07 )"
                               value={ this.state.birthdate }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                    <div className="form-group">
                        <label>Gender</label>
                        <select className="form-control"
                                name="gender"
                                value={ this.state.gender.toLowerCase() }
                                onChange={ (ev)=> this.handleInputChange(ev) }>
                            <option value="" disabled>Select gender</option>
                            <option value='male'>Male</option>
                            <option value='female'>Female</option>
                        </select>
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               className="form-control"
                               placeholder="Enter email"
                               value={ this.state.email }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                    <div className="form-group">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               className="form-control"
                               placeholder="Enter password"
                               value={ this.state.password }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                    <button type="submit"
                            className="btn btn-primary"
                            onClick={ (ev)=> this.handleSubmitForm(ev) }>Submit</button>
                </form>
            </div>
        )
    }
}

export default Register
