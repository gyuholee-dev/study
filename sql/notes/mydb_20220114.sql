---- ordr 주문요구서
-- numb 순번
-- item 물품명
-- kind 종류
-- date 요청일자
-- prce 단가
-- qntt 요청수량
-- dept 요청부서
-- stat 상태

CREATE TABLE ordr
(
  numb CHAR(3) NOT NULL,
  item CHAR(40),
  kind CHAR(1),
  date CHAR(10),
  prce INT,
  qntt INT,
  dept CHAR(2),
  stat CHAR(1),
  PRIMARY KEY(numb)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/text/ordr.txt'
INTO TABLE ordr
FIELDS TERMINATED BY '*';