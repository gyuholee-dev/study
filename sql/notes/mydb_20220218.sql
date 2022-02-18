/*
salefrut 제일청과
  seqn -- 번호
  yymd -- 일자
  comp -- 거래처
  prod -- 제품명
  prce -- 단가
  qnty -- 판매량
  dcnt -- 할인율
*/
CREATE TABLE salefrut (
  seqn INT AUTO_INCREMENT,
  yymd CHAR(10),
  comp CHAR(20),
  prod CHAR(10),
  prce INT,
  qnty INT,
  dcnt INT,
  PRIMARY KEY (seqn)
);
LOAD DATA INFILE 
'C:/Workspaces/study/sql/test34/data/custlist.txt' 
INTO TABLE custlist 
FIELDS TERMINATED BY '^' 
(yymd, comp, prod, prce, qnty, dcnt, @end);

/* custlist 한국유통
  code -- 코드
  comp -- 회사명
  pers -- 담당자
  posn -- 직위
  addr -- 주소
  cont -- 연락처
*/
CREATE TABLE custlist (
  code CHAR(5) NOT NULL,
  comp CHAR(20),
  pers CHAR(10),
  posn CHAR(10),
  addr CHAR(40),
  cont CHAR(8),
  PRIMARY KEY (code)
);
LOAD DATA INFILE 
'C:/Workspaces/study/sql/test34/data/custlist.txt' 
INTO TABLE custlist 
FIELDS TERMINATED BY '^' 
(code, comp, pers, posn, addr, cont, @end);

/* dealamnt 효성상사
  code -- 코드
  comp -- 회사명
  kind -- 거래구분
  qt_1 -- 1분기 
  qt_2 -- 2분기 
  qt_3 -- 3분기 
  qt_4 -- 4분기 
*/
CREATE TABLE dealamnt (
  code CHAR(5) NOT NULL,
  comp CHAR(20),
  kind CHAR(10),
  qt_1 INT,
  qt_2 INT,
  qt_3 INT,
  qt_4 INT,
  PRIMARY KEY (code)
);
LOAD DATA INFILE 
'C:/Workspaces/study/sql/test34/data/dealamnt.txt' 
INTO TABLE dealamnt 
FIELDS TERMINATED BY '^' 
(code, comp, kind, qt_1, qt_2, qt_3, qt_4, @end);

/* salelist 거래처
  seqn -- 번호
  yymd -- 일자
  comp -- 거래처
  prod -- 제품명
  prce -- 단가
  qnty -- 수량
*/
CREATE TABLE salelist (
  seqn INT AUTO_INCREMENT,
  yymd CHAR(10),
  comp CHAR(20),
  prod CHAR(10),
  prce INT,
  qnty INT,
  PRIMARY KEY (seqn)
);
LOAD DATA INFILE 
'C:/Workspaces/study/sql/test34/data/salelist.txt' 
INTO TABLE salelist 
FIELDS TERMINATED BY '^' 
(yymd, comp, prod, prce, qnty, @end);