import express from 'express';
export { router };
import crypto from 'crypto'; 

// -----------------------------------------------------------------------

// https://stackoverflow.com/questions/35242030/extending-express-router
// export class Router extends express.Router {
//   constructor() {
//     super();
//     this.path = super.route.path;
//     this.get('/', (req, res)=>{
//       res.send('Hello World!');
//     });
//   }

// }

const router = express.Router();

router.get('/', async(request, response)=>{
  let sid = '';
  if (request.cookies.loginId) {
    let cid = request.cookies.loginId;
    let sql = `SELECT * FROM member2_secret WHERE sid='${cid}'`;
    let result = await APP.database.query(sql);
    sid = result[0].id; 
  }

  let sql2 = `SELECT * FROM guest2 ORDER BY no DESC`;
  let result2 = await APP.database.query(sql2);
  response.render('list', {data:result2, id:sid});

});

router.get('/login', (request, response)=>{
  response.render('login');
});
router.post('/login', async(request, response)=>{
  const query = request.body;
  const id = query.id;
  const pw = query.pw;
  let sql = `SELECT * FROM member2 
             WHERE id='${id}' AND pw='${pw}'`;
  let result = await APP.database.query(sql);
  if(result.length !== 0) {
    const salt = Math.round((new Date().valueOf() * Math.random())) + '';
    const hashId = crypto.createHash('sha512').update(pw + salt).digest('hex');
    const expireDate = new Date(Date.now() + 60*60*1000*24);
    response.cookie('loginId', hashId, {
      expires: expireDate,
      httpOnly: true,
    });
    sql = `INSERT INTO member2_secret 
           VALUES('${id}', '${hashId}')`;
    await APP.database.query(sql);
    response.redirect('/');
  } else {
    response.send(`
      <script>
        alert("로그인 실패");
        history.back();
      </script>
    `);
  }
});
router.get('/logout', async(request, response)=>{
  let sql=`DELETE FROM member2_secret WHERE sid='${request.cookies.loginId}'`;
  await APP.database.query(sql);
  response.clearCookie('loginId');
  response.redirect('/');
});

router.get('/insert', (request, response)=>{
  response.render('insert');
});
router.post('/insert', async(request, response)=>{
  let sql = `SELECT id from member2_secret
             WHERE sid='${request.cookies.loginId}'`;
  let result = await APP.database.query(sql);
  const writer = result[0].id;
  const query = request.body;
  const memo = query.memo;
  const writeday = '2022-06-09';

  let sql2 = `INSERT INTO guest2
              VALUES(null, '${memo}', '${writer}', '${writeday}')`;
  await APP.database.query(sql2);
  response.redirect('/');
});

router.get('/edit/:no', async(request, response)=>{
  let sql = `SELECT * FROM guest2 WHERE no=${request.params.no}`;
  let result = await APP.database.query(sql);
  response.render('edit', {data:result[0]});
});
router.post('/edit/:no', async(request, response)=>{
  const query = request.body;
  const memo = query.memo;
  const no = request.params.no;

  let sql = `UPDATE guest2 SET memo='${memo}'
             WHERE no=${no}`;
  await APP.database.query(sql);
  response.redirect('/');
});

router.get('/delete/:no', async(request, response)=>{
  let sql = `DELETE FROM guest2 WHERE no=${request.params.no}`;
  await APP.database.query(sql);
  response.redirect('/');
});