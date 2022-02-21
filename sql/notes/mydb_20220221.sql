/* insurance 보험가입 현황
  numb -- 처리번호
  name -- 성명
  rnum -- 주민등록번호
  gend -- 성별
  sinc -- 가입일
  cont -- 보험구분
  prem -- 납입료
  area -- 가입지점
*/
CREATE TABLE insurance (
  numb CHAR(2) NOT NULL,
  name CHAR(10),
  rnum CHAR(14),
  gend CHAR(1),
  sinc CHAR(10),
  cont CHAR(12),
  prem INT,
  area CHAR(2),
  PRIMARY KEY (numb)
);

/* orderlist -- 유기농 식품 주문 현황
  + seqn -- 순서
  date -- 주문일자
  comp -- 주문처
  subj -- 품목
  prce -- 단가
  qnty -- 주문량
  pers -- 담당
*/
CREATE TABLE orderlist (
  seqn INT AUTO_INCREMENT,
  date CHAR(10),
  comp CHAR(10),
  subj CHAR(16),
  prce INT,
  qnty INT,
  pers CHAR(10),
  PRIMARY KEY (seqn)
);

/* membership -- 체육센터 회원 현황
  numb -- 번호
  memb -- ID
  name -- 이름
  stud -- 종목
  dues -- 이용료
  stat -- 납부상태
  inst -- 담당
*/
CREATE TABLE membership (
  numb CHAR(2) NOT NULL,
  memb CHAR(5),
  name CHAR(10),
  stud CHAR(12),
  dues INT,
  stat CHAR(3),
  inst CHAR(10),
  PRIMARY KEY (numb)
);


/* shopping -- 온라인쇼핑몰
  + seqn -- 순서 
  date -- 판매일자
  code -- 제품코드
  subj -- 제품분류
  prce -- 단가
  qnty -- 수량
  dcnt -- 할인율
  cust -- 구매자번호
  agee -- 나이
  gend -- 성별
*/
CREATE TABLE shopping (
  seqn INT AUTO_INCREMENT,
  date CHAR(10),
  code CHAR(9),
  subj CHAR(12),
  prce INT,
  qnty INT,
  dcnt INT,
  cust CHAR(5),
  agee CHAR(2),
  gend CHAR(1),
  PRIMARY KEY (seqn)
);