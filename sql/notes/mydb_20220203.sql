-- 마스터 테이블 2개 트랜잭션 테이블 2개

/* itemmast 제품마스터
itemcode 제품코드
descript 제품명
itemspec 제품규격
itemkind 제품구분
innprice 입고단가
outprice 출고단가
inventry 재고량
*/
CREATE TABLE itemmast
(
  itemcode CHAR(2) NOT NULL,
  descript CHAR(20),
  itemspec CHAR(20),
  itemkind CHAR(2),
  innprice INT,
  outprice INT,
  inventry INT,
  PRIMARY KEY(itemcode)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/test29/data/itemmast.txt'
INTO TABLE itemmast
FIELDS TERMINATED BY '/';

/* salesman 판매원마스터
salecode 판매원코드
salename 판매원명
salegend 성별
innndate 입점일자
salearea 판매지역
*/
CREATE TABLE salesman
(
  salecode CHAR(2) NOT NULL,
  salename CHAR(10),
  salegend CHAR(1),
  innndate CHAR(10),
  salearea CHAR(20),
  PRIMARY KEY(salecode)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/test29/data/salesman.txt'
INTO TABLE salesman
FIELDS TERMINATED BY '/';

/* inntran 제품입고
serialno 
trandate 입고일자
trancode 입고제품
tranqnty 입고수량
tranprce 입고단가
trankind 입출구분 (I)
*/
CREATE TABLE inntran
(
  serialno INT AUTO_INCREMENT,
  trandate CHAR(10),
  trancode CHAR(2),
  tranqnty INT,
  tranprce INT,
  trankind CHAR(1),
  PRIMARY KEY(serialno)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/test29/data/inntran.txt'
INTO TABLE inntran
FIELDS TERMINATED BY '^';


/* outtran 제품출고
serialno 
trandate 출고일자
salecode 판매원코드
trancode 출고제품
tranqnty 출고수량
tranprce 출고단가
trankind 입출구분 (O)
*/
CREATE TABLE outtran
(
  serialno INT AUTO_INCREMENT,
  trandate CHAR(10),
  salecode CHAR(2),
  trancode CHAR(2),
  tranqnty INT,
  tranprce INT,
  trankind CHAR(1),
  PRIMARY KEY(serialno)
);

LOAD DATA INFILE 'C:/Workspaces/study/sql/test29/data/outtran.txt'
INTO TABLE outtran
FIELDS TERMINATED BY '^';

