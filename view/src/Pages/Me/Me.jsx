import React from 'react'
import axios from 'axios'

import { isAuth, getToken, getUserId } from './../../services'
import { ImageForm } from './../../Components'


class Me extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            token: null,
            userId: null,
            user: null
        }
    }

    componentDidMount()
    {
        if(isAuth())
        {
            this.setState({
                token: getToken(),
                userId: getUserId()
            })
        }
    }

    handleInputChange(ev)
    {
        let newUser = {
            ...this.state.user,
            [ev.target.name]: ev.target.value
        }

        this.setState({
            ...this.state,
            user: newUser
        })
    }

    handleChangeImages(images)
    {
        console.log(images)
    }

    handleSubmitForm(ev)
    {
        ev.preventDefault()
        axios.post('/user/update', {
            name: this.state.user.name,
            gender: this.state.user.gender,
            birth_date: this.state.user.birthdate,
            email: this.state.user.email,
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

    getUser()
    {
        axios.get('/me?auth_token=' + this.state.token + '&user_id=' + this.state.userId).then((user)=> {
            if(user.status === 200)
            {
                console.log(user.data)
                this.setState({
                    user: {
                        name: user.data.name,
                        gender: user.data.gender,
                        birthdate: user.data.birth_date.date,
                        email: user.data.email,
                        images: user.data.images.map((image)=> {
                            return image.path
                        }),
                        description: user.data.description,
                        minAge: user.data.preferences.age.min,
                        maxAge: user.data.preferences.age.max,
                        distance: user.data.preferences.distance
                    }
                })
            }
        }).catch((error)=> {
            console.log(error)
        })
    }

    renderForm()
    {
        return (
            <form>
                <div className="form-group">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           className="form-control"
                           placeholder="Enter email"
                           value={ this.state.user.name }
                           onChange={ (ev)=> this.handleInputChange(ev) } />
                </div>
                <div className="form-group">
                    <label>Birthdate</label>
                    <input type="text"
                           name="birthdate"
                           className="form-control"
                           placeholder="Enter birthdate ( ex: 1989-11-07 )"
                           value={ this.state.user.birthdate }
                           onChange={ (ev)=> this.handleInputChange(ev) } />
                </div>
                <div className="form-group">
                    <label>Gender</label>
                    <select className="form-control"
                            name="gender"
                            value={ this.state.user.gender.toLowerCase() }
                            onChange={ (ev)=> this.handleInputChange(ev) }>
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
                           value={ this.state.user.email }
                           onChange={ (ev)=> this.handleInputChange(ev) } />
                </div>

                <hr />
                <div className="pb-2">
                    <strong>Images:</strong>
                </div>
                <ImageForm images={ this.state.user.images } onChange={ (images)=>this.handleChangeImages(images) } />

                <hr />

                <div className="pb-2">
                    <strong>Description:</strong>
                </div>
                <div className="form-group">
                    <textarea className="form-control"
                              name="description"
                              rows="3"
                              value={ this.state.user.description }
                              onChange={ (ev)=> this.handleInputChange(ev) }></textarea>
                </div>

                <hr />

                <div className="pb-2">
                    <strong>Preferences:</strong>
                </div>

                <div className="form-row mb-3">
                    <div className="col">
                        <input type="number"
                               min="18"
                               max="65"
                               className="form-control"
                               placeholder="Min age"
                               value={ this.state.user.minAge }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                    <div className="col">
                        <input type="number"
                               min="18"
                               max="65"
                               className="form-control"
                               placeholder="Max age"
                               value={ this.state.user.maxAge }
                               onChange={ (ev)=> this.handleInputChange(ev) } />
                    </div>
                </div>

                <div className="form-group">
                    <label>Distance around my location</label>
                    <input type="number"
                           min="0"
                           max="100"
                           name="distance"
                           className="form-control"
                           placeholder="Enter distance in KM"
                           value={ this.state.user.distance }
                           onChange={ (ev)=> this.handleInputChange(ev) } />
                </div>

                <hr />

                <button type="submit"
                        className="btn btn-primary"
                        onClick={ (ev)=> this.handleSubmitForm(ev) }>Save</button>
            </form>
        )
    }


    render()
    {
        if(this.state.token && this.state.userId && !this.state.user)
        {
            this.getUser()
        }

        return (
            <div className="row justify-content-center" style={{ height: '80vh', overflow: 'scroll' }}>
                <div className="col-md-6">
                    { this.state.user ? this.renderForm() : null }
                </div>
            </div>
        )
    }
}

export default Me
