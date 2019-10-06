/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import React, { useState } from 'react';
import ReactDom from 'react-dom';

const divStyle = {
  margin: '40px',
  padding: '10px',
  border: '1px solid black'
};

let App = () => {
  const [count, setCount] = useState(0);

  return (
    <div style={divStyle}>
      <p>Vous avez cliqué {count} fois</p>
      <button onClick={() => setCount(count + 1)}>
        Cliquez ici
      </button>
    </div>
  )
}

ReactDom.render(<App />, document.getElementById('root'));
