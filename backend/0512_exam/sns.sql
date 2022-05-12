/* sns 글
sns_no 글번호
writer 작성자
writeday 작성일
file 첨부파일
message 글내용
*/
DROP TABLE IF EXISTS sns;
CREATE TABLE sns (
  sns_no INT AUTO_INCREMENT,
  writer VARCHAR(20) NOT NULL,
  writeday INT,
  file VARCHAR(80),
  message TEXT,
  PRIMARY KEY (sns_no)
);

/* sns_re 답글
re_no 글번호
writer 작성자
writeday 작성일
message 답글내용
sns_no 부모 글번호
*/
DROP TABLE IF EXISTS sns_re;
CREATE TABLE sns_re (
  re_no INT AUTO_INCREMENT,
  writer VARCHAR(20) NOT NULL,
  writeday INT,
  message TEXT,
  sns_no INT NOT NULL,
  PRIMARY KEY (re_no)
);

/* member 회원
-- 기존 member 테이블 사용
id 아이디
pw 패스워드
name 이름
email 이메일
*/

-----------------------------------------------------------
-- 테스트데이터

-- sns 글
INSERT INTO sns (writer, writeday, file, message)
VALUES ('test', '1652325069', 'files/testimage.jpg', '안녕하세요 반갑습니다 글내용입니다');

-- sns_re 답글
INSERT INTO sns_re (writer, writeday, message, sns_no)
VALUES ('test', '1652325184', '첫번째 답글입니다 안녕하세요', 1);

INSERT INTO sns_re (writer, writeday, message, sns_no)
VALUES ('test', '1652325228', '두번째 답글입니다 안녕하세요', 1);

INSERT INTO sns_re (writer, writeday, message, sns_no)
VALUES ('test', '1652325280', '세번째 답글입니다 안녕하세요', 1);

INSERT INTO sns_re (writer, writeday, message, sns_no)
VALUES ('test', '1652325292', '네번째 답글입니다 안녕하세요', 1);

INSERT INTO sns_re (writer, writeday, message, sns_no)
VALUES ('test', '1652325306', '다섯번째 답글입니다 안녕하세요', 1);

