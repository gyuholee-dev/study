const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
// LEVEL 5 : + MODE OPTION
// https://how-to.dev/how-to-read-mode-in-webpackconfigjs
// https://yamoo9.gitbook.io/webpack/webpack/webpack-plugins/extract-css-files
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
  if(mode === 'production') { // 배포 모드인 경우 css 익스트랙트 추가
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
    entry: [
      './src/main.js',
    ],
    devtool: 'source-map',
    plugins: plugins,
    module: {
      rules: [
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