import * as url from 'url';
import path from 'path';
import { 
  mysqlTest,
  getUserData,
  getNotice,
  getQna,
  insertNotice,
} from './functions.js';

// 라우터 클래스
export class Router {
  constructor (server, publicDir) {
    this.server = server;
    this.publicDir = publicDir;
    this.viewsDir = path.resolve('views');
  }

  async route (request, response) {
    const method = request.method;
    const urls = url.parse(request.url, true);
    const pathname = urls.pathname;
  
    if (method === 'GET') { 

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
      switch(pathname) {
        case '/' || '/main':
          document = 'index.ejs';
          break;
        case '/notice':
          document = 'notice.ejs';
          data = await getNotice();
          break;
        case '/qna':
          document = 'qna.ejs';
          data = await getQna();
          break;
        case 'insert':
          document = 'insert.ejs';
          break;
        default:
          document = pathname + '.ejs';
      }
      response.render(path.join(this.viewsDir, document), {data:data});

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
        case '/insert':
          await insertNotice(query);
          response.redirect('/notice');
          break;
      }

    }
  }


}