/* paint 영화감상
numb 작품번호
name 작품명
pntr 작가명
kind 구분
comt 작품해설
*/

CREATE TABLE paint
(
  numb CHAR(2) NOT NULL,
  name CHAR(30),
  pntr CHAR(20),
  kind CHAR(4),
  comt VARCHAR(999),
  PRIMARY KEY(numb)
);

---- 메인메뉴
-- 조회
-- 생성
-- 입력
-- 수정