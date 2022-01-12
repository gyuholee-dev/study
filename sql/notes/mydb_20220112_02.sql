---- 판매관리 테이블 sale 생성
-- numb 순번
-- date 판매일
-- item 판매품목
-- prce 단가
-- qntt 수량
-- supp 판매처

CREATE TABLE sale
(
  numb INT AUTO_INCREMENT,
  date CHAR(10),
  item CHAR(40),
  prce INT,
  qntt INT,
  supp CHAR(4),
  PRIMARY KEY(numb)
);

Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2021-12-30','바나나','1500','10','1112');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2021-12-30','사과','1000','20','1114');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-03','딸기','2000','3','1116');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-03','포도','3000','2','1113');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-03','바나나','1500','5','1112');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-04','사과','1000','15','1114');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-04','딸기','2000','5','1115');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-04','바나나','1500','7','1116');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-04','포도','3000','5','1117');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-03','복숭아','2500','10','1112');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-05','사과','1000','30','1113');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-05','딸기','2000','15','1114');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-05','포도','3000','60','1115');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-05','복숭아','2500','90','1116');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-06','바나나','1500','35','1118');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-06','사과','1000','50','1114');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-05','배','5000','70','1115');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-07','바나나','1500','23','1116');
Insert into Sale(Date,Item,Prce,Qntt,Supp) values('2022-01-07','사과','1000','14','1117');

-- SELECT sale.*, supp.name FROM sale
-- JOIN supp ON sale.supp = supp.code
-- ORDER BY sale.date
-- LIMIT 0, 6;

SELECT a.*, b.name FROM sale a
JOIN supp b ON a.supp = b.code
ORDER BY a.date DESC
LIMIT 0, 6;