---- empl 인사명부
-- numb 사원번호
-- name 성명
-- gend 성별
-- dept 소속
-- grad 직위
-- entr 입사일
-- phon 연락처
-- bord 재직여부

CREATE TABLE empl
(
  numb CHAR(4) NOT NULL,
  name CHAR(15), 
  gend CHAR(1),
  dept CHAR(2),
  grad CHAR(2),
  entr CHAR(10),
  phon CHAR(13),
  bord CHAR(1),
  PRIMARY KEY(numb)
)