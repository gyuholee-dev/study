---- asst 고정자산 관리
/*
numb 자산번호
name 자산명
dept 자산위치
prce 단가
qntt 수량
date 구입일자
*/

CREATE TABLE asst
(
  numb CHAR(4) NOT NULL,
  name CHAR(50),
  dept CHAR(2),
  prce INT,
  qntt INT,
  date CHAR(10),
  PRIMARY KEY(numb)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/text/asst.txt'
INTO TABLE asst
FIELDS TERMINATED BY '~';

SELECT a.*, b.name FROM asst a
JOIN dept b ON a.dept = b.code
WHERE numb = '1135';