import mysql from 'mysql';
import fs from 'fs';

// 데이터베이스 클래스
export default class Database {
  constructor (dbConfig=null) {
    if (!dbConfig) {
      // const dbConfig = JSON.parse(fs.readFileSync('./config/db.json', 'utf8'));
      dbConfig = {
        host     : 'localhost',
        user     : 'root',
        password : null,
        port     : '3306',
        socketPath: null,
        database : 'testdb'
      }
    }
    this.dbConfig = dbConfig;
    this.DB = mysql.createConnection(dbConfig);
    this.DB.connect();
  }

  async query(sql) {
    sql = sql.replace(/\n\s+/g, ' ');
    return new Promise((resolve, reject) => {
      this.DB.query(sql, (error, results, fields) => {
        if (error) {
          return reject(error);
        }
        resolve(results);
      });
    });
  }
}