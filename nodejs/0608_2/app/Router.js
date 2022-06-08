import * as url from 'url';
import path from 'path';
import { 
  getAttendance,
  getLastNum,
  insertAttendance,
} from './functions.js';

// 라우터 클래스
export class Router {
  constructor (server, paths) {
    this.server = server;
    this.publicPath = path.resolve(paths.pub);
    this.viewsPath = path.resolve(paths.view);
  }

  async route (request, response) {
    const method = request.method;
    const urls = url.parse(request.url, true);
    const pathname = urls.pathname;
  
    if (method === 'GET') { 

      // EJS 도큐먼트
      let document = 'index.ejs';
      let data = {};
      const query = urls.query;
      // console.log('GET:', query);

      switch(pathname) {
        case '/' || '/main':
          data = await getAttendance();
          document = 'index.ejs';
          break;
        case '/insert':
          data = await getLastNum(query);
          document = 'insert.ejs';
          break;
        default:
          document = pathname + '.ejs';
      }
      response.render(path.join(this.viewsPath, document), {data:data});

    } else if (method === 'POST') {

      let data = {};
      const query = request.body;
      // console.log('POST:', query);

      // 포스트 페이지
      switch(pathname) {
        case '/insert':
          await insertAttendance(query);
          response.redirect('/');
          break;
      }

    }
  }


}