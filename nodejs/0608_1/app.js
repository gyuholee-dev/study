import express from 'express';
import ejs from 'ejs';
import path from 'path';

import cookieParser from 'cookie-parser';

import { Router } from './app/Router.js';
import { Database } from './app/Database.js';

// -----------------------------------------------------------------------

// 서버 시작
function start(hostname, port, publicPath) {
  APP.server.use(
    express.static(publicPath),
    express.json(),
    express.urlencoded({extended:false}),
    cookieParser(), // 쿠키
  );
  APP.server.set( // ejs 셋업
    'view engine', 'ejs', 
    'views', path.resolve('views'),
  );
  APP.server.all('*', (request, response)=>{
    APP.router.route(request, response);
  });
  APP.server.listen(port, hostname, ()=>{
    console.log(`SERVER STARTED: http://${hostname}:${port}/`);
  });
}

// -----------------------------------------------------------------------

// 전역 객체
// https://tutorialpost.apptilus.com/code/posts/nodejs/ns-global-object/
const APP = {};
global.APP = APP;

// TODO: config.json 로드
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
const publicPath = path.resolve(APP.config.paths.pub);
APP.server = express();
APP.router = new Router(APP.server, publicPath);
APP.database = new Database();

// 서버 실행
start(APP.config.hostname, APP.config.port, publicPath);