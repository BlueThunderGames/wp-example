const path = require('path');

module.exports = {
    entry: {
        app: './assets/js/src/index.js',
    },
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'assets/js/dist'),
    },
};