import express from 'express';
import ejs from 'ejs';
import path from 'path';

import cookieParser from 'cookie-parser';

import { Router } from './app/Router.js';
import { Database } from './app/Database.js';

// -----------------------------------------------------------------------

// 서버 시작
function start(hostname, port, paths) {
  const publicPath = path.resolve(paths.pub);
  const viewsPath = path.resolve(paths.view);
  APP.server.use(
    express.static(publicPath),
    express.json(),
    express.urlencoded({extended:false}),
    cookieParser(), // 쿠키
  );
  APP.server.set( // ejs 셋업
    'view engine', 'ejs', 
    'views', viewsPath,
  );

  // 라우트 패스 https://psyhm.tistory.com/7
  APP.server.all('/*/:num', (request, response)=>{
    APP.router.route(request, response, request.params);
  });
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
APP.router = new Router(APP.server, APP.config.paths);
APP.database = new Database();

// 서버 실행
start(APP.config.hostname, APP.config.port, APP.config.paths);