import * as url from 'url';
import fs from 'fs';
import path from 'path';

import pages from './pages.js';

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
        response.status(404).send('404 NOT FOUND');
        // throw new Error('404 NOT FOUND');
      }
    }
    
    if (method === 'GET') { 

      // HTML 도큐먼트
      // let document = 'index.html';
      // const query = urls.query;
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
      switch(pathname) {
        case 'index' || 'main':
          document = 'index.ejs';
          response.render(document, {data:data});
          break;
        default:
          this[pathname](method, request, response);
          break;
      }
      // response.render(document, {data:data});

    } else if (method === 'POST') {

      // 포스트 데이터
      let data = {};
      const query = request.body;

      // 포스트 xhr
      if (query.call) {
        switch(query.call) {
          // case 'test':
            // data = await mysqlTest();
            // break;
          default:
            data = await this[query.call]();
            break;
        }
        response.json(data);
      }

      // 포스트 페이지
      switch(pathname) {
        default:
          this[pathname](method, request, response);
          break;
      }

    }
  }

}