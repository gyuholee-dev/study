CREATE TABLE guest (
  no INT AUTO_INCREMENT PRIMARY KEY,
  memo TEXT,
  writer VARCHAR(20),
  writeday VARCHAR(20)
);

-- drop table quest_re;
CREATE TABLE guest_re (  
  no INT AUTO_INCREMENT PRIMARY KEY,
  memo TEXT,
  writer VARCHAR(20),
  p_no INT
);


CREATE TABLE member (
	id VARCHAR(20) NOT NULL,
	name VARCHAR(20),
	email VARCHAR(30),
	pw VARCHAR(20),
	gender VARCHAR(10),
	hobby1 VARCHAR(10),
	hobby2 VARCHAR(10),
	hobby3 VARCHAR(10),
	hobby4 VARCHAR(10),
	hobby5 VARCHAR(10),
	grade VARCHAR(10),
	comment TEXT,
	PRIMARY KEY (id)
);

INSERT into member (id, pw) VALUES ('test', '1234');
