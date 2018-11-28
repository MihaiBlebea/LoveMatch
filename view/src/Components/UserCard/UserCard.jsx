import React from 'react'
import UserImage from './UserImage'
import './UserCard.css'


class UserCard extends React.Component
{
    constructor()
    {
        super()
        this.state = {
            cardFront: true
        }
    }

    changeCardState()
    {
        this.setState({
            cardFront: !this.state.cardFront
        })
    }

    renderCardImage()
    {
        if(this.state.cardFront)
        {
            return (
                <UserImage images={ this.props.images }/>
            )
        }
        return null
    }

    renderCardFront()
    {
        return (
            <div>
                <h4 className="card-title text-center">{ this.props.name }</h4>
                <p className="card-text">{ this.props.description }</p>
            </div>
        )
    }

    renderCardBack()
    {
        return (
            <div>
                <h4 className="card-title text-center">Details</h4>
                <div className="card-text pb-3">
                    Nimic de vazut
                </div>
            </div>
        )
    }

    render()
    {
        return (
            <div className="card" style={{ maxWidth: '400px' }}>

                { this.renderCardImage() }

                <div className="card-body">

                    { this.state.cardFront === true ? this.renderCardFront() : this.renderCardBack() }

                    <div className="row justify-content-between px-3">
                        <button className="btn btn-danger" onClick={ ()=> this.props.onPass() }><i className="fas fa-angle-double-left"></i> Pass</button>
                        <button className="btn btn-primary" onClick={ ()=> this.changeCardState() }>See Profile <i className="far fa-user"></i></button>
                        <button className="btn btn-success" onClick={ ()=> this.props.onLike() }>Like <i className="fas fa-angle-double-right"></i></button>
                    </div>
                </div>
            </div>
        )
    }
}

export default UserCard
