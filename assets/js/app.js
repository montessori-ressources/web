/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import React, { Component } from 'react';
import ReactDom from 'react-dom';
// import Home from "./components/Home";

function App() {
  return (
    <>
        <p>Test</p>
    </>
  )
}

ReactDom.render(<App />, document.getElementById('root'));
