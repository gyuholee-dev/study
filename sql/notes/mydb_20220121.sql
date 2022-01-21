-- 마스터 테이블
/*
-- toyy 장난감
numb 장난감번호
name 장난감명
stat 대여여부 (H:보유, R:대여)
rent 대여료
date 구입일자
ammt 구입금액
*/
CREATE TABLE toyy
(
  numb CHAR(2) NOT NULL,
  name CHAR(20),
  stat CHAR(1),
  rent INT,
  date CHAR(10),
  ammt INT,
  PRIMARY KEY(numb)
);

-- 
/* 
-- cust 고객
numb 고객번호
name 고객명
phon 전화번호
addr 주소
jobb 직업
*/
/*
code 데이터:
16 11 일반인
16 12 직장인
16 13 학생
16 14 유아

*/

CREATE TABLE cust
(
  numb CHAR(2) NOT NULL,
  name CHAR(15),
  phon CHAR(13),
  addr VARCHAR(99),
  jobb CHAR(2),
  PRIMARY KEY(numb)
);

-- 트랜잭션 테이블
/*
-- rent 대여 및 반납
seqn 일련번호
date 대여일자
cust 고객번호
toyy 장난감번호
stat 대여상태 (R:대여, B:반납)
retn 반납일자
*/
CREATE TABLE rent
(
  seqn INT AUTO_INCREMENT,
  date CHAR(10),
  cust CHAR(2),
  toyy CHAR(2),
  stat CHAR(1),
  retn CHAR(10),
  PRIMARY KEY(seqn)
);


/*
장난감: 생성, 입력, 조회, 편집
고객: 생성, 입력, 조회, 편집
대여,반납: 대여등록, 대여취소, 반납등록, 반납취소
자료조회: 