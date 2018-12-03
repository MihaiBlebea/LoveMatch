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

    resetCardState()
    {
        this.setState({
            cardFront: true
        })
    }

    handleLike()
    {
        this.resetCardState()
        return this.props.onLike()
    }

    handlePass()
    {
        this.resetCardState()
        return this.props.onPass()
    }

    renderCardImage()
    {
        if(this.state.cardFront)
        {
            return (
                <UserImage images={ this.props.images } gender={ this.props.gender }/>
            )
        }
        return null
    }

    renderCardFront()
    {
        return (
            <div>
                <h5 className="card-title text-center">{ this.props.name }</h5>
            </div>
        )
    }

    renderCardBack()
    {
        return (
            <div>
                <h4 className="card-title text-center">Details</h4>
                <div className="card-text pb-3">
                    { this.props.description }
                </div>
            </div>
        )
    }

    render()
    {
        return (
            <div className="card">

                { this.renderCardImage() }

                <div className="card-body">

                    { this.state.cardFront === true ? this.renderCardFront() : this.renderCardBack() }

                    <div className="row justify-content-between px-3">
                        <button className="btn btn-danger col-md-3 col-sm-12 mb-2 mb-md-0"
                                onClick={ ()=> this.handlePass() }><i className="fas fa-ban"></i></button>
                        <button className="btn btn-primary col-md-5 col-sm-12 mb-2 mb-md-0"
                                onClick={ ()=> this.changeCardState() }>Profile <i className="far fa-user"></i></button>
                        <button className="btn btn-success col-md-3 col-sm-12 mb-2 mb-md-0"
                                onClick={ ()=> this.handleLike() }><i className="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
        )
    }
}

export default UserCard
