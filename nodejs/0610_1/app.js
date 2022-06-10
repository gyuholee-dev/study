import Server from './app/Server.js';
import fs from 'fs';

// 컨피그
// const config = JSON.parse(fs.readFileSync('./config/config.json', 'utf8'));
const config = {
  hostname: 'localhost',
  port: 5000,
  // 디렉토리
  paths : {
    app : 'app',
    pub : 'public',
    view : 'views',
    src : 'src',
    conf : 'config',
  },
  db : {
    host : 'localhost',
    user : 'root',
    password : null,
    port : '3306',
    socketPath: null,
    database : 'testdb'
  }
}

global.APP = new Server(config);
APP.start();
