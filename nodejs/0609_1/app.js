import express from 'express';
import ejs from 'ejs';
import path from 'path';

import cookieParser from 'cookie-parser';
import crypto from 'crypto'; 

import { Database } from './app/Database.js';
import { router } from './app/Router.js';

// -----------------------------------------------------------------------

// 서버 시작
function start(hostname, port, paths) {
  const publicPath = path.resolve(paths.pub);
  const viewsPath = path.resolve(paths.view);

  APP.server.use( // 미들웨어
    // express.static(publicPath),
    // express.json(),
    express.urlencoded({extended:false}),
    cookieParser(), // 쿠키
  );
  APP.server.set( // 뷰 엔진, ejs
    'view engine', 'ejs', 
    'views', viewsPath,
  );

  // 라우터 미들웨어 https://expressjs.com/ko/guide/routing.html
  // 다른 미들웨어를 먼저 거쳐야 하기 때문에 마지막으로 추가해야 함.
  APP.server.use('/', APP.router);

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
APP.router = router;

// 서버 실행
start(APP.config.hostname, APP.config.port, APP.config.paths);