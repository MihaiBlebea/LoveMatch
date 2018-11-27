import React from 'react'
import ReactDOM from 'react-dom'
import dotenv from 'dotenv'
import axios from 'axios'

import App from './App'


dotenv.config()

axios.defaults.baseURL = 'http://localhost:8800'
axios.interceptors.request.use((request)=> {
    return request
})

ReactDOM.render(<App />, document.getElementById('root'));
