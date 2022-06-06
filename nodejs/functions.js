import fs from 'fs';
import mysql from 'mysql';

function getJson(file) {
  const json = fs.readFileSync(file, 'utf8');
  return JSON.parse(json);
}

// https://www.npmjs.com/package/mysql
// https://jacobgrowthstory.tistory.com/19
function mysqlTest() {
  const mysqli = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : null,
    port     : '3306',
    socketPath: null,
    // database : 'blog'
  });
  mysqli.connect();

  let sql = `
    SELECT * FROM blog.post
    WHERE postid = 23;
  `;
  return new Promise((resolve, reject) => {
    mysqli.query(sql, (error, results, fields) => {
      if (error) {
        return reject(error);
      }
      resolve(results[0]);
    });
  });
}

export { 
  getJson,
  mysqlTest
};