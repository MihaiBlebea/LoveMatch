import React from 'react'
import { Navigation } from './../index'

import './Container.css'


const Container = (props)=> {
    return (
        <div className="container">
            <div className="row mt-5 mb-5">
                <div className="col">
                    <div className="card" style={{ borderWidth: '0px' }}>
                        <div className="background-nav py-2 px-3 text-white"
                             style={{ borderTopLeftRadius: '.25rem', borderTopRightRadius: '.25rem' }}>
                            <Navigation />
                        </div>

                        <div className="card-body py-0">
                            { props.children }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Container
