class App extends React.Component {

    state = {
        value: this.props.expression
    };

    handleMouseEnter = () => {
        this.setState({
            value: this.props.value
        });
    }

    handleMouseLeave = () => {
        this.setState({
            value: this.props.expression
        });
    }

    render() {
         return React.createElement('div', {
            style: {
            },
            onMouseEnter: this.handleMouseEnter,
            onMouseLeave: this.handleMouseLeave
         }, `Expression/Value: ${
            React.createElement('span', {
                style: {
                },
                onMouseEnter: this.handleMouseEnter,
                onMouseLeave: this.handleMouseLeave
             }, `Expression/Value: ${
                React.createElement
             }`
         }`);
    }
}

ReactDOM.render(
    React.createElement(App, {
        expression: drupalSettings.amazee_math.expression,
        value: drupalSettings.amazee_math.value
    }),
    document.getElementById('react-output')
);