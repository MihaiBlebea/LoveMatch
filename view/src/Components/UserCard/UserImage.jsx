import React from 'react'


class UserImage extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            images: null,
            index: 0
        }
    }

    componentDidMount()
    {
        this.setState({
            images: this.props.images
        })
    }

    nextImage()
    {
        let nextIndex = this.state.images.length > this.state.index + 1 ? this.state.index + 1 : 0
        this.setState({
            index: nextIndex
        })
    }

    getImage()
    {
        if(this.props.images.length > 0)
        {
            return this.props.images[this.state.index].path
        }

        if(this.props.gender === 'FEMALE')
        {
            return 'https://www.w3schools.com/bootstrap4/img_avatar5.png'
        }
        return 'https://www.w3schools.com/bootstrap4/img_avatar1.png'
    }

    render()
    {
        return (
            <img className="card-img-top"
                 style={{ cursor: 'pointer' }}
                 src={ this.getImage() }
                 onClick={ ()=> this.nextImage() }/>
        )
    }
}

export default UserImage
