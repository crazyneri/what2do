import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App/App';

ReactDOM.render(
    <App
        id={document.getElementById('app').dataset.id}
    />,
    document.getElementById('app')
);