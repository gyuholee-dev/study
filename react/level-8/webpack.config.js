const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
// LEVEL 8 : + React
// https://haerim95.tistory.com/7
// https://velog.io/@lee_yesol421/React-webpack-%EC%84%A4%EC%A0%95%ED%95%98%EA%B8%B0
module.exports = (env, argv)=>{
  const watch = (env.WEBPACK_WATCH === 'true'); // true | false
  const mode = argv.mode ? argv.mode : 'development'; // "production" | "development" | "none"
  const filename = (mode === 'production') ? 'bundle.min.js' : 'bundle.js';

  const plugins = [
    new HtmlWebpackPlugin({
      minify: {
        collapseWhitespace: true
      },
      hash: true,
      template: './src/index.html'
    })
  ];
  if(mode === 'production') {
    plugins.push(new MiniCssExtractPlugin({
      filename: 'styles/style.min.css'
    }));
  }
  const styleLoader = (mode === 'production') ? MiniCssExtractPlugin.loader : 'style-loader';

  return {
    mode: mode,
    watch: watch,
    watchOptions: {
      ignored: /node_modules/,
    },
    devServer: {
      static: false,
      watchFiles: ["./src/*"],
      open: true,
      hot: true,
      compress: true,
      port: 9000,
    },
    entry: [
      // './src/main.js',
      // resolve.extensions에서 확장자 지정하면 app에서 파일 확장자 생략 가능
      './src/main',
    ],
    resolve: {
      // jsx 파일 추가
    	extensions: [ '.js', '.jsx'],
    },
    devtool: 'source-map',
    plugins: plugins,
    module: {
      // jsx 트랜스파일 추가
      rules: [
        {
          test: /\.jsx?$/,
          loader: 'babel-loader',
          options: {
            presets: [
             '@babel/preset-env', 
             '@babel/preset-react'
            ],
            plugins: [
              // https://babeljs.io/docs/en/babel-plugin-proposal-class-properties
              // '@babel/plugin-proposal-class-properties'
            ], 
          },
          exclude: /node_modules/
        },
        {
          test: /\.s[ac]ss$/i,
          use: [ 
            styleLoader,
            "css-loader",
            "sass-loader",
          ],
          exclude: /node_modules/
        }
      ]
    },
    output: {
      path: path.resolve(__dirname, "dist"),
      filename: filename,
    }
  }
}