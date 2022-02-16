/* CREATE TABLE traineee (
  no1
  no2
  name CHAR(10),
  gend CHAR(1),
  phon CHAR(13),
  addr CHAR(99),
  etc1 CHAR(6),
  etc2 CHAR(6),
  PRIMARY KEY (no1, no2)
);

LOAD DATA INFILE 'traineee.txt'
INTO TABLE traineee
FIELDS TERMINATED BY '^'; */

/*
업무일지
넘버 오토
날짜 10
성명 10
출근 4
퇴근 4
직급 2
오전업무 40
오후업무 40

-- 날짜별, 이름별로 선택 가능

*/

CREATE TABLE dailyreport (
  seqn INT AUTO_INCREMENT,
  date CHAR(10),
  name CHAR(10),
  innn CHAR(4),
  outt CHAR(4),
  posn CHAR(2),
  amwk CHAR(30),
  pmwk CHAR(30),
  PRIMARY KEY (seqn)
);

-- date  date('Y-m-d')
-- innn, outt date('hi')
-- posn 

LOAD DATA INFILE 
'C:/Workspaces/study/sql/test<>/data/dailyreport.txt' 
INTO TABLE dailyreport 
FIELDS TERMINATED BY '^' 
(date, name, innn, outt, posn, amwk, mwk);

LOAD DATA INFILE 
'C:/Workspaces/study/sql/text/qualific.txt' 
INTO TABLE code 
FIELDS TERMINATED BY '^' 

