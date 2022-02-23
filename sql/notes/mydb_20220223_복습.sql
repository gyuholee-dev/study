
---- 트랜잭션 관리
START TRANSACTION; -- 트랜잭션 시작
ROLLBACK; -- 트랜잭션 되돌리기 
COMMIT;  -- 트랜잭션 확정 


---- 테이블 카피
-- 단, PRIMARY KEY 와 AUTO_INCREMENT 가 빠짐
-- CREATE TABLE [새 테이블] AS SELECT * FROM [기존 테이블]
CREATE TABLE lect1 AS SELECT * FROM lect;
CREATE TABLE lect2 AS SELECT * FROM lect WHERE kind='H';

-- 테이블 구조 카피
-- 데이터는 들어오지 않음
-- CREATE TABLE [새 테이블] LIKE [기존 테이블]
CREATE TABLE lect3 LIKE lect;

-- 레코드 카피
-- 구조 카피를 먼저 한 뒤 레코드를 카피해야 함
-- INSERT INTO [타겟] SELECT * FROM [프롬];
INSERT INTO lect3 SELECT * FROM lect;


---- View 뷰 만들기
-- 링크된 복제 테이블
-- 원본 테이블 부하를 줄임
-- 복잡한 쿼리를 매번 수행하지 않음
-- 테이블명_v 로 네이밍(보통)
-- (동일복제일 경우) 레코드 변경이 양방향으로 반영됨
-- (쿼리결과 복제일 경우) 뷰 변경 불가능, 원본만 변경가능
-- CREATE VIEW [뷰] AS SELECT * FROM [테이블]
CREATE VIEW lect_v 
AS SELECT * FROM lect;
CREATE VIEW lect_v1 
AS SELECT 
SUM(hour) AS hours, 
SUM(feee) AS feees 
FROM lect;
CREATE VIEW insurance_v
AS SELECT
cont, area, SUM(prem) AS prems
FROM insurance
GROUP BY cont, area


---- 구분자 변경
-- DELIMITER [구분자]
DELIMITER //
DELIMITER ;


---- 트리거
-- 테이블 변경내역
-- 구분자 변경을 활용

-- 삭제 트리거
DELIMITER //
CREATE TRIGGER trg1 BEFORE DELETE ON lect FOR EACH ROW
BEGIN
  INSERT INTO lect_trg 
  VALUES (
    old.code, 
    old.name,
    old.kind,
    old.hour,
    old.inwn,
    old.feee,
    old.teac,
    'D'
  );
END //
DELIMITER ;

-- 입력 트리거
DELIMITER //
CREATE TRIGGER trg2 BEFORE INSERT ON lect FOR EACH ROW
BEGIN
  INSERT INTO lect_trg 
  VALUES (
    new.code, 
    new.name,
    new.kind,
    new.hour,
    new.inwn,
    new.feee,
    new.teac,
    'I'
  );
END //
DELIMITER ;

-- 수정 트리거
DELIMITER //
CREATE TRIGGER trg3 AFTER UPDATE ON lect FOR EACH ROW
BEGIN
  INSERT INTO lect_trg 
  VALUES (
    old.code, 
    old.name,
    old.kind,
    old.hour,
    old.inwn,
    old.feee,
    old.teac,
    'O'
  );
  INSERT INTO lect_trg 
  VALUES (
    new.code, 
    new.name,
    new.kind,
    new.hour,
    new.inwn,
    new.feee,
    new.teac,
    'N'
  );
END //
DELIMITER ;

-- 히스토리 로깅 테이블 생성
DROP TABLE IF EXISTS lect_trg;
CREATE TABLE lect_trg (
  code CHAR(3),
  name CHAR(20),
  kind CHAR(1),
  hour INT,
  inwn INT,
  feee INT,
  teac CHAR(3),
  what CHAR(1)
);



