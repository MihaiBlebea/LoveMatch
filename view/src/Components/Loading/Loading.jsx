import React from 'react'
import './Loading.css'


const Loading = (props)=> {
    const renderLoading = ()=> {
        return (
            <div className="loading-bg position-absolute" style={{ left: 0, right: 0, top: 0, bottom: 0 }}>
                <div className="row h-100 justify-content-center align-items-center">
                    <div className="col-1">
                        <div className="lds-heart">
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }

    return props.show ? renderLoading() : null
}

export default Loading
