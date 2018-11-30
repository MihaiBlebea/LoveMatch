import React from 'react'
import axios from 'axios'
import EventBus from 'eventing-bus'


import { isAuth, getToken, getUserId } from './../../services'
import { UserForm, ImageForm, PreferenceForm } from './../../Components'


class MyProfile extends React.Component
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

    handleImageChange(images)
    {
        let newUser = {
            ...this.state.user,
            images: images
        }

        this.setState({
            ...this.state,
            user: newUser
        })
    }

    handleSubmitForm(ev)
    {
        ev.preventDefault()
        axios.post('/test', {
            id: this.state.user.id,
            name: this.state.user.name,
            gender: this.state.user.gender,
            birth_date: this.state.user.birthdate,
            email: this.state.user.email,
            longitude: '26.0835',
            latitude: '44.5672',
            description: this.state.user.description,
            images: this.state.user.images,
            min_age: this.state.user.minAge,
            max_age: this.state.user.maxAge,
            distance: this.state.user.distance
        }).then((result)=> {
            if(result.status === 200)
            {
                EventBus.publish('triggerAlert', { message: 'Data was saved', type: 'success' })
            }
        }).catch((error)=> {
            EventBus.publish('triggerAlert', { message: 'Something went wrong', type: 'danger' })
            console.log(error)
        })
    }

    handleCancelForm(ev)
    {
        ev.preventDefault()
        this.props.history.goBack()
    }

    getUser()
    {
        axios.get('/user?auth_token=' + this.state.token + '&user_id=' + this.state.userId).then((user)=> {
            if(user.status === 200)
            {
                console.log(user.data)
                this.setState({
                    user: {
                        id: user.data.id,
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
                <UserForm name={ this.state.user.name }
                          birthdate={ this.state.user.birthdate }
                          gender={ this.state.user.gender }
                          email={ this.state.user.email }
                          onInputChange={ (ev)=> this.handleInputChange(ev) }/>

                <hr />

                <div className="pb-2">
                    <strong>Images:</strong>
                </div>
                <ImageForm images={ this.state.user.images }
                           onChange={ (images)=>this.handleImageChange(images) } />

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

                <PreferenceForm minAge={ this.state.user.minAge }
                                maxAge={ this.state.user.maxAge }
                                distance={ this.state.user.distance }
                                onInputChange={ (ev)=> this.handleInputChange(ev) } />

                <hr />

                <div className="row justify-content-between px-3">
                    <button className="btn btn-danger"
                            onClick={ (ev)=> this.handleCancelForm(ev) }>Cancel</button>
                    <button type="submit"
                            className="btn btn-success"
                            onClick={ (ev)=> this.handleSubmitForm(ev) }>Save</button>
                </div>
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
            <div className="row justify-content-center" style={{ height: '80vh', overflowY: 'scroll' }}>
                <div className="col-md-6 pt-5 pb-5">
                    { this.state.user ? this.renderForm() : null }
                </div>
            </div>
        )
    }
}

export default MyProfile
