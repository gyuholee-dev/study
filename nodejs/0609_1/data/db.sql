CREATE TABLE member2 (
  id VARCHAR(20),
  pw VARCHAR(20)
);

CREATE TABLE member2_secret (
  id VARCHAR(20),
  sid VARCHAR(200)
);

CREATE TABLE guest2 (
  no INT AUTO_INCREMENT,
  memo TEXT,
  writer VARCHAR(20),
  writeday VARCHAR(20),
  PRIMARY KEY (no)
);

INSERT INTO member2 VALUES ('test', '1234');
