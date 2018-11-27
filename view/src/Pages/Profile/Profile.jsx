import React from 'react'
import axios from 'axios'

import { UserCard } from './../../Components'


class Profile extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            profiles: [],
            userId: '7AC47F10-7C23-44AE-A4A2-F80AA145386E',
            token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjcmVhdGVkX29uIjoiMjAxOC0xMS0yNlQyMToxNDo1MC45NTg3NTBaIiwiZXhwaXJlcyI6MzYwMCwiZW1haWwiOiJtaWhhaXNlcmJhbi5ibGViZWFAZ21haWwuY29tIiwicGFzc3dvcmQiOiIkMnkkMTAkODVMXC9ZQVNEUXB2WmM2d1FxakFpM3VZZENIZlpWZ1ZOOW13VXZkU2JtVmdvaHREOWhraExHIiwidXNlcl9pZCI6IjdBQzQ3RjEwLTdDMjMtNDRBRS1BNEEyLUY4MEFBMTQ1Mzg2RSJ9.GiJ0f8-haLB1A0JjNtZ2W9-mvm8RkeWf1prZQ_SQbU4'
        }
        this.getProfiles()
    }

    getProfiles()
    {
        axios.get('/users?count=20&user_id=' + this.state.userId + '&auth_token=' + this.state.token).then((profiles)=> {
            this.setState({
                ...this.state,
                profiles: profiles.data
            })
        }).catch((error)=> {
            console.log(error)
        })
    }

    renderUserCards()
    {

        if(this.state.profiles.length > 0)
        {
            return this.state.profiles.map((profile, index)=> {
                return ( <UserCard key={ index } name={ profile.name }/> )
            })
        }
        return null
    }

    render()
    {
        return (
            <div className="container">
                <div className="row mt-5 mb-5">
                    <div className="col">
                        <div className="card">
                            <div className="card-body">
                                <h1>Profiles</h1>

                                { this.renderUserCards() }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Profile
