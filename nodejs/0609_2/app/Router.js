import * as url from 'url';
import fs from 'fs';
import path from 'path';

import pages from './router/pages.js';

// https://www.npmjs.com/package/path-to-regexp
import { pathToRegexp, match, parse, compile } from 'path-to-regexp';
const regexp = pathToRegexp('/:path?/:do?/:id?');

let publicPath, viewsPath;

// 라우터 클래스
export default class Router {
  constructor (config) {
    const paths = config.paths;
    publicPath = path.resolve(paths.pub);
    viewsPath = path.resolve(paths.view);
    Object.assign(this, pages);
  }

  async route (request, response) {
    const method = request.method;
    const urls = url.parse(request.url, true);
    const paths = urls.pathname;
    const params = regexp.exec(paths);
    const pathname = (params[1])? params[1] : 'index';

    // 파일 우선 처리
    // TODO: 메서드로 분리
    const ext =  paths.split('.').pop().toLowerCase();
    if (ext !== paths && ext !== 'html') {
      console.log(ext);
      const filePath = path.join(publicPath, ext, paths);
      if (fs.existsSync (filePath)) {
        response.sendFile(filePath);
      } else {
        response.status(404).send('NOT FOUND');
      }
    }
    
    if (method === 'GET') { 
      // throw new Error('에러에러');

      // HTML 도큐먼트
      // let document = 'index.html';
      // const query = urls.query;
      // // console.log('GET:', query);
      // switch(pathname) {
      //   case '/' || '/main':
      //     document = 'index.html';
      //     break;
      //   default:
      //     document = pathname + '.html';
      // }
      // response.sendFile(path.join(this.publicDir, document));

      // EJS 도큐먼트
      let document = 'index.ejs';
      let data = {};
      const query = urls.query;
      // console.log('GET:', query);
      // console.log('pathname:', pathname);
      switch(pathname) {
        case 'index' || 'main':
          document = 'index.ejs';
          response.render(document, {data:data});
          break;
        // case '/notice':
        //   document = 'notice.ejs';
        //   data = await getNotice();
        //   break;
        // case '/qna':
        //   document = 'qna.ejs';
        //   data = await getQna();
        //   break;
        // case 'insert':
        //   document = 'insert.ejs';
        //   break;
        default:
          // document = pathname + '.ejs';
          // const fnName = pathname.split('/')[1];
          // if (fnName !== 'favicon.ico') {
          //   this[fnName]();
          // }
          break;
      }
      // response.render(document, {data:data});

    } else if (method === 'POST') {

      // 포스트 데이터
      let data = {};
      const query = request.body;
      // console.log('POST:', query);

      // 포스트 xhr
      // if (!query.call) return false;
      // switch(query.call) {
      //   case 'test':
      //     // data = getJson('test.json');
      //     // data = await mysqlTest();
      //     break;
      //   case 'getUserData':
      //     // data = await getUserData(query);
      //     break;
      // }
      // response.json(pathname);

      // 포스트 페이지
      switch(pathname) {
        // case '/insert':
        //   await insertNotice(query);
        //   response.redirect('/notice');
        //   break;
      }

    }
  }

  // test( request, response ) {
  //   console.log('test');
  // }


}