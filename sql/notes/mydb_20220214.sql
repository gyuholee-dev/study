-- 고정자산 관리
CREATE TABLE fixasset (
  asstnumb CHAR(3) NOT NULL,
  asstname CHAR(20),
  asstdate CHAR(10),
  asstprce INT,
  asstqnty INT,
  asstdept CHAR(2),
  asststat CHAR(1),
  dusedate CHAR(10),
  duseresn CHAR(20),
  PRIMARY KEY (asstnumb)
);

CREATE TABLE requestt (
  sequence INT AUTO_INCREMENT,
  reqrdate CHAR(10),
  reqrnumb CHAR(3),
  reqrqnty INT,
  reqrpers CHAR(10),
  ordrdate CHAR(10),
  ordrsupp CHAR(4),
  dueedate CHAR(10),
  PRIMARY KEY (sequence)
);
