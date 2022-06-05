import React from 'react';
import { createRoot } from 'react-dom/client';
import { ReactTest } from './Component';

// import './main.scss';
// const message = document.createTextNode("Webpack Example");
// document.body.appendChild(message);

const container = document.getElementById('root');
const root = createRoot(container);
root.render(<ReactTest />);
