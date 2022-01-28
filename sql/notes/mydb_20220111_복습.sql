---- supp 거래처 테이블
-- code 코드, 
-- name 거래처명, 
-- numb 사업자No, 
-- repr 대표자, 
-- type 업태, 
-- prod 종목, 
-- phon 전화번호

-- 테이블 생성
CREATE TABLE supp
(
  code CHAR(4) NOT NULL,
  name CHAR(40),
  numb CHAR(12),
  repr CHAR(20),
  type CHAR(40),
  prod CHAR(40),
  phon CHAR(13),
  PRIMARY KEY(code)
);

INSERT INTO supp
SET ('1111','신한은행','320-24-61345','김정국','금융','대출,예금','010-3012-6134');

-- 모든 데이터 적재
LOAD DATA INFILE 'C:/Workspaces/study/sql/text/supp.txt'
INTO TABLE supp
FIELDS TERMINATED BY '^';
-- ERROR 1262 (01000): Row 1 was truncated; it contained more data than there were input columns