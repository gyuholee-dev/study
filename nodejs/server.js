// https://expressjs.com/ko/
// https://velog.io/@goody/NodeJs-Express-%EB%A1%9C-%EC%9B%B9%EC%84%9C%EB%B2%84-%EA%B5%AC%EC%B6%95%ED%95%98%EA%B8%B0
// https://juni-dev-log.tistory.com/61
// https://jinbroing.tistory.com/87
// https://codingapple.com/unit/nodejs-react-integration/
// https://velopert.com/1456
// https://opentutorials.org/course/2136/11886
// https://amkorousagi-money.tistory.com/entry/express%EC%97%90%EC%84%9C-get-post-%ED%8C%8C%EB%9D%BC%EB%AF%B8%ED%84%B0-%EA%B0%80%EC%A0%B8%EC%98%A4%EA%B8%B0
// https://dev-dain.tistory.com/66

// import 문을 쓸려면 package.json 에 "type": "module" 을 추가해야 한다.
import express from 'express';
import * as fs from 'fs';
import * as url from 'url';
import path from 'path';

import { getJson, mysqlTest } from './functions.js';

// ------------------------------------------------------------

// 내장 라우팅
// app.route('/')
// .get((request, response)=>{
//   response.send('Get a random book');
// })
// .post((request, response)=>{
//   response.send('Add a book');
// })
// .put((request, response)=>{
//   response.send('Update the book');
// });

// 라우팅 함수
async function router(request, response, publicDir) {
  const method = request.method;
  const urls = url.parse(request.url, true);
  const pathname = urls.pathname;

  if (method === 'GET') { 
    // 도큐먼트
    let document = '';
    const query = urls.query;
    // console.log('GET:', query);
    switch(pathname) {
      case '/' || '/main':
        document = 'main.html';
        break;
      default:
        document = pathname + '.html';
    }
    response.sendFile(path.join(publicDir, document));
  } else if (method === 'POST') {
    // 데이터
    let data = {};
    const query = request.body;
    console.log('POST:', query);
    if (!query.call) return false;
    switch(query.call) {
      case 'test':
        // data = getJson('test.json');
        data = await mysqlTest();
        break;
    }
    response.json(data);
  }
}


// 서버 시작
function start(hostname, port, dir, router) {
  // https://stackoverflow.com/questions/46745014/alternative-for-dirname-in-node-js-when-using-es6-modules
  // https://codenbike.tistory.com/221
  const publicDir = path.resolve(dir);
  app.listen(port, hostname, ()=>{
    console.log(`SERVER STARTED: http://${hostname}:${port}/`);
  });
  app.use(
    express.static(publicDir), // 스태틱 파일 디렉토리 https://backback.tistory.com/338
    express.json(), // json 데이터
    express.urlencoded({extended: true}) // post 데이터 https://eunhee-programming.tistory.com/229
  );
  app.all('*', (request, response)=>{ // 모든 요청
    // console.log(`REQUEST: ${request.url}`);
    router(request, response, publicDir); // 라우터 함수 호출
  });
}

// -------------------------------------------------------------------
// 익스프레스 서버 생성
const app = express();
// 서버 실행
start('localhost', 3000, 'public', router);
