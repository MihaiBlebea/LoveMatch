import React from 'react'


class ImageForm extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            images: null
        }
    }

    componentDidMount()
    {
        this.setState({
            images: this.props.images
        })
    }

    handleInputChange(ev, index)
    {
        let images = this.state.images
        images[index] = ev.target.value

        this.setState({
            images: images
        })

        this.props.onChange(this.state.images)
    }

    addBlankInput(ev)
    {
        ev.preventDefault()
        let images = this.state.images
        images[this.state.images.length] = ''

        this.setState({
            images: images
        })
    }

    removeInput(ev, index)
    {
        ev.preventDefault()
        let images = this.state.images
        images.splice(index, 1)

        this.setState({
            images: images
        })

        this.props.onChange(this.state.images)
    }

    render()
    {
        if(this.state.images)
        {
            let imageInputs = this.state.images.map((image, index)=> {
                return (
                    <div className="input-group mb-3" key={ index }>
                        <input type="text"
                               className="form-control"
                               placeholder="Profile image"
                               value={ image }
                               onChange={ (ev)=> this.handleInputChange(ev, index) }/>
                        <div className="input-group-append">
                            <button className="btn btn-outline-secondary"
                                    onClick={ (ev)=> this.removeInput(ev, index) }>
                                <i className="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                )
            })
            return (
                <div>
                    { imageInputs }
                    <button className="btn btn-secondary"
                            onClick={ (ev)=> this.addBlankInput(ev) }>Add</button>
                </div>
            )
        }
        return null
    }
}

export default ImageForm
