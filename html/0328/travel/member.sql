
/* member 멤버
name 이름
email-1 이메일
email-2 이메일 선택
id 아이디
pw-1 패스워드
-- pw-2 패스워드 확인
gender 
hobby-1
hobby-2
hobby-3
hobby-4
hobby-5
grade
comment
*/

CREATE TABLE member (
  id VARCHAR(20) NOT NULL PRIMARY KEY,
  name VARCHAR(20),
  email VARCHAR(30),
  pw VARCHAR(20),
  gender VARCHAR(10),
  hobby1 VARCHAR(10),
  hobby2 VARCHAR(10),
  hobby3 VARCHAR(10),
  hobby4 VARCHAR(10),
  hobby5 VARCHAR(10),
  grade VARCHAR(10),
  comment TEXT
);