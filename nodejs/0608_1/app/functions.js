
function mysqlTest() {
  let sql = `
    SELECT * FROM shop_member 
    WHERE memberid = 'test'; 
  `;
  return APP.database.query(sql)[0];
}

async function getUserData(query) {
  const memberid = query.memberid;
  const password = query.password;
  let sql = `
    SELECT * FROM shop_member 
    WHERE memberid = '${memberid}'
    AND password = AES_ENCRYPT('${password}', '${password}');
  `;
  let result = await APP.database.query(sql);
  return result[0];
}

async function getNotice() {
  let sql = `
    SELECT * FROM notice
    ORDER BY no DESC
    Limit 5;
  `;
  let result = await APP.database.query(sql);
  return result;
}

async function getQna() {
  let sql = `
    SELECT * FROM qna
    ORDER BY no DESC
  `;
  let result = await APP.database.query(sql);
  return result;
}

async function insertNotice(query) {
  let writeday = '2022-06-08';
  let sql = `
    INSERT INTO notice (title, writer, writeday, content)
    VALUES ('${query.title}', '${query.writer}', '${writeday}', '${query.content}');
  `;
  let result = await APP.database.query(sql);
  return result;
}


export { 
  mysqlTest,
  getUserData,
  getNotice,
  getQna,
  insertNotice,
};