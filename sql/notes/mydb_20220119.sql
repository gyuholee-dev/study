/* 
test21.php 
test21_create.php 생성
test21_insert.php 등록
test21_select.php 조회
test21_update.php 수정

// trip 사원출장 관리
serl 순서
numb 사번
date 출장일자
days 출장일수
plce 출장지
purp 출장목적
tran 교통숙박비
food 식비
etcs 여비
comp 동행자
 */

CREATE TABLE trip
(
  serl INT AUTO_INCREMENT,
  numb CHAR(4),
  date CHAR(10),
  days INT,
  plce CHAR(2),
  purp CHAR(30),
  tran INT,
  food INT,
  etcs INT,
  comp CHAR(1),
  PRIMARY KEY(serl)
);

SELECT trip.*, empl.name AS numb_name, code.name AS plce_name FROM trip
JOIN empl ON trip.numb = empl.numb
JOIN code ON trip.plce = code.cod2 AND code.cod1 = '13'; 