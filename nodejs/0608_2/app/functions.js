async function getAttendance() {
  let sql = `
    SELECT * FROM attendance
    ORDER BY student_num ASC;
  `;
  let result = await APP.database.query(sql);
  return result;
}

async function getLastNum() {
  let sql = `
    SELECT MAX(student_num) AS lastNum FROM attendance
  `;
  let result = await APP.database.query(sql);
  return result[0];
}

async function insertAttendance(query) {
  let sql = `
    INSERT INTO attendance 
    (student_num, student_name, attend_cond, absent_reason)
    VALUES
    ('${query.student_num}', '${query.student_name}', '${query.attend_cond}', '${query.absent_reason}');
  `;
  let result = await APP.database.query(sql);
  return result;
}

// --------------------------------------------------------------------------------------------------------------------

export { 
  getAttendance,
  getLastNum,
  insertAttendance,
};