const React = require('react');
const { Component } = React;

class ReactTest extends Component {
	state = {
    text : '리액트 테스트 성공!!! 😊',
  };
  
  render(){
    return <h1>{this.state.text}</h1>
  }
}

export {
  ReactTest,
}