// LEVEL 1 : Basic js
// https://webpack.kr/configuration/
module.exports = {
  mode: "production", // "production" | "development" | "none"
  entry: "./src/main.js",
  output: {
    path: __dirname + "/dist", // path.resolve(__dirname, "dist")
    filename: "script.js",
  }
}