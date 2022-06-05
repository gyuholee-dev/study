const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
// LEVEL 3 : + SASS + CSS
// https://poiemaweb.com/sass-webpack
// https://webpack.js.org/loaders/sass-loader/
// https://yamoo9.gitbook.io/webpack/webpack/webpack-plugins/extract-css-files
module.exports = {
  mode: "development", // "production" | "development" | "none"
  entry: [
    './src/main.js',
  ],
  devtool: 'source-map',
  // css 별도 저장시
  plugins: [
    new MiniCssExtractPlugin({ filename: 'styles/style.css' })
  ],
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [ 
          MiniCssExtractPlugin.loader, // css 별도 저장
          "css-loader",
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