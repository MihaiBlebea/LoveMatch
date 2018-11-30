import React from 'react'


class UserForm extends React.Component
{
    render()
    {
        return (
            <div>
                <div className="form-group">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           className="form-control"
                           placeholder="Enter email"
                           value={ this.props.name }
                           onChange={ (ev)=> this.props.onInputChange(ev) } />
                </div>
                <div className="form-group">
                    <label>Birthdate</label>
                    <input type="text"
                           name="birthdate"
                           className="form-control"
                           placeholder="Enter birthdate ( ex: 1989-11-07 )"
                           value={ this.props.birthdate }
                           onChange={ (ev)=> this.props.onInputChange(ev) } />
                </div>
                <div className="form-group">
                    <label>Gender</label>
                    <select className="form-control"
                            name="gender"
                            value={ this.props.gender.toLowerCase() }
                            onChange={ (ev)=> this.props.onInputChange(ev) }>
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
                           value={ this.props.email }
                           onChange={ (ev)=> this.props.onInputChange(ev) } />
                </div>
            </div>
        )
    }
}

export default UserForm
