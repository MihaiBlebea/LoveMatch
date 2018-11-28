import React from 'react'


const Container = (props)=> {
    return (
        <div className="container">
            <div className="row mt-5 mb-5">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            { props.children }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Container
