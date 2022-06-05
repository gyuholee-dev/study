const path = require('path');
// LEVEL 2 : + SASS
// https://poiemaweb.com/sass-webpack
// https://webpack.js.org/loaders/sass-loader/
module.exports = {
  mode: "development", // "production" | "development" | "none"
  entry: [
    './src/main.js',
    './src/main.scss'
  ],
  devtool: 'source-map',
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [ // 기본 옵션, js 번들링, 뒤에서부터 적용
          // Creates `style` nodes from JS strings
          "style-loader",
          // Translates CSS into CommonJS
          "css-loader",
          // Compiles Sass to CSS
          "sass-loader",
        ],
        exclude: /node_modules/
      }
    ]
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "script.js",
  }
}