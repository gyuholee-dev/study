---- code 테이블 추가

-- 14번 가족관계
INSERT INTO code VALUES('14', '11', '아버지', 'Y');
INSERT INTO code VALUES('14', '12', '어머니', 'Y');
INSERT INTO code VALUES('14', '13', '남편', 'Y');
INSERT INTO code VALUES('14', '14', '아내', 'Y');
INSERT INTO code VALUES('14', '15', '아들', 'Y');
INSERT INTO code VALUES('14', '16', '딸', 'Y');

--15번 상, 벌
INSERT INTO code VALUES('15', '11', '장기근속상', 'Y');
INSERT INTO code VALUES('15', '12', '최우수사원상', 'Y');
INSERT INTO code VALUES('15', '13', '우수사원상', 'Y');
INSERT INTO code VALUES('15', '14', '모범사원상', 'Y');
INSERT INTO code VALUES('15', '15', '해고', 'Y');
INSERT INTO code VALUES('15', '16', '강등', 'Y');
INSERT INTO code VALUES('15', '17', '감봉', 'Y');
INSERT INTO code VALUES('15', '18', '견책', 'Y');
INSERT INTO code VALUES('15', '19', '경고', 'Y');

/*
---- 가족사항
-- 사원번호
-- 가족관계
-- 성명
-- 나이
-- 직업
-- 동거여부
*/

/* rewd 상벌
seqn 순서
empl 사원번호 
date 상벌일자
kind 구분
code 상벌코드
resn 상벌사유
remk 비고
*/
CREATE TABLE rewd
(
  seqn INT AUTO_INCREMENT,
  empl CHAR(4),
  date CHAR(10),
  kind CHAR(1),
  code CHAR(2),
  resn CHAR(40),
  remk CHAR(40),
  PRIMARY KEY(seqn)
)