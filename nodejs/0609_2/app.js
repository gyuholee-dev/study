import express from 'express';
import session from 'express-session';
import fileStore from 'session-file-store';
const FileStore = fileStore(session);
import ejs from 'ejs';
import path from 'path';

import cookieParser from 'cookie-parser';
import crypto from 'crypto'; 

import { Database } from './app/Database.js';
import { Router } from './app/Router.js';

// -----------------------------------------------------------------------

// 서버 시작
function start(hostname, port, paths) {
  const publicPath = path.resolve(paths.pub);
  const viewsPath = path.resolve(paths.view);

  APP.server.use( // 미들웨어
    // 세션 
    // nodemon 서버 재시작 방지 https://www.npmjs.com/package/nodemon 참조
    // https://velog.io/@gidskql6671/nodemon-ignore-watch-%EC%84%A4%EC%A0%95
    session({ 
      secret: "secret key",
      resave: false,
      saveUninitialized: true,
      store: new FileStore(),
    }),
    cookieParser(), // 쿠키
    // express.static(publicPath),
    // express.json(),
    express.urlencoded({extended:false}),
  );
  APP.server.set( // 뷰 엔진, ejs
    'view engine', 'ejs', 
    'views', viewsPath,
  );

  // APP.server.use('/', APP.router);
  // APP.server.use('/', APP.router.route);
  APP.server.all('*', (request, response)=>{
    APP.router.route(request, response);
  });

  APP.server.listen(port, hostname, ()=>{
    console.log(`SERVER STARTED: http://${hostname}:${port}/`);
  });

}

// -----------------------------------------------------------------------

// 전역 객체
const APP = {};
global.APP = APP;

APP.config = {
  hostname: 'localhost',
  port: 5000,
  // 디렉토리
  paths : {
    app : 'app',
    pub : 'public',
    view : 'views',
    src : 'src',
    conf : 'config',
  }
}

// 익스프레스 서버 생성
APP.server = express();
APP.database = new Database();
APP.router = new Router(APP.server, APP.config.paths);

// 서버 실행
start(APP.config.hostname, APP.config.port, APP.config.paths);