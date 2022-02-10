CREATE TABLE subject
(
  subjcode CHAR(2) NOT NULL,
  subjname CHAR(20),
  subjkind CHAR(1),
  opendate CHAR(10),
  noperson INT,
  teacname CHAR(10),
  amtprice INT,
  usestate CHAR(1),
  PRIMARY KEY(subjcode)
);

LOAD DATA 
INFILE 'C:/Workspaces/study/sql/test31/data/subject.txt'
INTO TABLE subject
FIELDS TERMINATED BY '^';

CREATE TABLE student
(
  subjcode CHAR(2) NOT NULL,
  studnumb CHAR(2) NOT NULL,
  studname CHAR(10),
  studgend CHAR(1),
  phonnumb CHAR(13),
  areaname CHAR(30),
  PRIMARY KEY(subjcode, studnumb)
);

LOAD DATA 
INFILE 'C:/Workspaces/study/sql/test31/data/student.txt'
INTO TABLE student
FIELDS TERMINATED BY '^';

CREATE TABLE examines
(
  serialno INT AUTO_INCREMENT,
  subjcode CHAR(2),
  studnumb CHAR(2),
  exam_1st INT,
  exam_2nd INT,
  exam_3rd INT,
  PRIMARY KEY(serialno)
);