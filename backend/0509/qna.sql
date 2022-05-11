-- Q&A 테이블, testdb 에 생성
CREATE TABLE qna (
  no INT AUTO_INCREMENT,
  title VARCHAR(100),
  content TEXT,
  writer VARCHAR(20),
  writeday VARCHAR(20),
  step INT,
  f_no INT,
  hit INT DEFAULT 0,
  PRIMARY KEY (no)
);