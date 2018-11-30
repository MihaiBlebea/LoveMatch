import React from 'react'


class PreferenceForm extends React.Component
{
    constructor()
    {
        super()
        this.state = {

        }
    }

    render()
    {
        return (
            <div>
                <div className="form-row mb-3">
                    <div className="col">
                        <input type="number"
                               min="18"
                               max="65"
                               name="minAge"
                               className="form-control"
                               placeholder="Min age"
                               value={ this.props.minAge }
                               onChange={ (ev)=> this.props.onInputChange(ev) } />
                    </div>
                    <div className="col">
                        <input type="number"
                               min="18"
                               max="65"
                               name="maxAge"
                               className="form-control"
                               placeholder="Max age"
                               value={ this.props.maxAge }
                               onChange={ (ev)=> this.props.onInputChange(ev) } />
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
                           value={ this.props.distance }
                           onChange={ (ev)=> this.props.onInputChange(ev) } />
                </div>
            </div>
        )
    }
}

export default PreferenceForm
