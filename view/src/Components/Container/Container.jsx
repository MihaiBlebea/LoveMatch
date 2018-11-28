import React from 'react'
import { Navigation } from './../index'


const Container = (props)=> {
    return (
        <div className="container">
            <div className="row mt-5 mb-5">
                <div className="col">
                    <div className="card" style={{ borderWidth: '0px' }}>
                        <div className="bg-success py-2 px-3 text-white"
                             style={{ borderTopLeftRadius: '.25rem', borderTopRightRadius: '.25rem' }}>
                            <Navigation />
                        </div>

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
