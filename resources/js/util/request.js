import axios from 'axios';

const get = async (url, config = {}) => {

    config.headers = {
        ...(config.headers || {}),
        'Accept': 'application/json',
        'Content-type': 'application/json'
    }

    return await axios.get(url, config);
}


const post = async (url, data, config = {}) => {

    config.headers = {
        ...(config.headers || {}),
        'Accept': 'application/json',
        'Content-type': 'application/json',
    }

    return await axios.post(url, data, config);
}

export { get, post }