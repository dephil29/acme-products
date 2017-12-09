import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import Request from 'superagent';
import _ from 'lodash';

class App extends Component {
  constructor() {
    super();
    this.state = {};
}

componentWillMount() {
  var url = "http://localhost/acme-products/api/read_all_products.php";
  Request.post(url).then((response) => {
    this.setState({
      all: response.text
    })
  })
}

  render() {
    var all = _.map(this.state.all, (one) => {
      return <div>{one.name}</div>;
    })
    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Welcome to CRUD</h1>
        </header>
        <div>This is CRUD:</div>
        <span>{all}</span>
      </div>
    );
  }
}

export default App;




// render() {        
//     return(
//         <div>
//             <div>Items:</div>
//             { this.state.items.map(item=> { return <div>{`http://item.name`}</div>}) }          
//         </div>  
//     );
// }
// }

// export default App;