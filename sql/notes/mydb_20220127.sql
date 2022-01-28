/* stud 
cous CHAR(3) // 강좌코드 PK
numb CHAR(2) // 학생 학번 PK
name CHAR(10) // 성명
phon CHAR(13) // 연락처
jobb CHAR(10) // 직업
*/
CREATE TABLE stud
(
  cous CHAR(3) NOT NULL,
  numb CHAR(2) NOT NULL,
  name CHAR(10),
  phon CHAR(13),
  jobb CHAR(10),
  PRIMARY KEY(cous, numb)
);

/*
      수강생 등록
----------------------
과정선택( )      [확인]
----------------------
no  성명  연락처  직업