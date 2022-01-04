----------------------------------
-- 고정자산관리 Asst 테이블 추가
-- 번호, 자산명, 구분, 단가, 수량, 부서
create table asst
    (
        numb char(4) not null,
        name char(30),
        kind char(1),
        prce int,
        qntt int,
        dept char(2),
        primary key(numb)
    );
desc asst;
select * from asst;
-- asst 레코드 추가
insert into asst(numb,name,kind,prce,qntt,dept)
    values
    ('1111','컴퓨터','P',500,5,'11'),
    ('1112','에어컨','P',800,10,'12'),
    ('1113','의자','S',700,3,'14'),
    ('1114','LG컴퓨터','P',600,7,'14'),
    ('1115','철재의자','S',300,20,'11'),
    ('1116','소형의자','W',100,30,'21'),
    ('1117','선풍기','P',50,6,'12'),
    ('1118','히터','P',40,8,'13'),
    ('1119','책장','W',200,2,'21'),
    ('1120','프린터','S',150,12,'11'),
    ('1121','모니터','P',90,11,'12');
select * from asst;
----------------------------------
-- 조인
-- asst 테이블과 dept 테이블 join
-- 일단 조인
select * from asst
    join dept on asst.dept = dept.code;
-- 중복 열(dept=code)은 빼고 필요한 데이터만 조인
select asst.*,dept.name from asst
    join dept on asst.dept = dept.code;
-- 알리어스 네임 사용
select a.*, b.name from asst as a
    join dept as b on a.dept = b.code;
----------------------------------
-- 셀렉트 테스트
-- 고정자산 품목갯수 및 각각 수량 합계
select count(*),sum(qntt) from asst;
-- 제일 비싼 단가, 제일 싼 단가, 단가 평균
select max(prce),min(prce),avg(prce) from asst;
-- 회사 자산의 총금액 합계
select sum(prce*qntt) from asst;
-- 구분(kind)가 'P' 인 자산의 단가평균 및 수량평균
select avg(prce),avg(qntt) from asst
    where kind='P';
-- 부서가 12인 자산의 품목갯수 및 수량합계
select count(*),sum(qntt) from asst
    where dept='12';
-- 단가 500원 이상 수량 10개 이상 자산 모두 셀렉트
select * from asst
    where prce>=500 and qntt>=10;
-- 자산명에 '컴퓨터' 가 포함되어 있는 자산의 총 수량
select sum(qntt) from asst
    where name like '%컴퓨터%';
-- 11 부서에 있거나 'P'제품인 레코드 전부 선택
select * from asst
    where dept='11' or kind='P';
-- 수량이 많은 순으로 셀렉트
select * from asst
    order by qntt desc;
-- 부서 12번인 것들을 단가가 싼 자산부터 순서대로
select * from asst
    where dept='12'
    order by prce asc;
-- kind 순서 (W>S>P), 동일한 kind일 경우 부서순서대로
select * from asst
    order by kind desc, dept asc;
-- 품명이 '터' 로 끝나는 자산을 품명순으로 셀렉트
select * from asst
    where name like '%터'
    order by name asc;
-- 회사 의자의 총 갯수 (철재의자 및 소형의자 등)
select sum(qntt) from asst
    where name like '%의자%';
-- 가격 비싼순서대로 상위 4개만
select * from asst
    order by prce desc
    limit 0, 4;
-- 부서별로 그룹화하여 각 부서별 자산갯수 및 수량합계
SELECT dept, COUNT(*), SUM(qntt) FROM asst
  GROUP BY dept;
-- 구분(kind)별로 그룹화하여 각 그룹별 수량합계, 수량 10개 이상
SELECT kind, SUM(qntt) FROM asst
  WHERE qntt >= 10
  GROUP BY kind;
----------------------------------
-- 업데이트 테스트
-- 자산번호 '1111' 의 자산명을 '컴퓨터본체' 로 수정
UPDATE asst
  SET name = '컴퓨터본체'
  WHERE numb = '1111';
-- 수량이 10개 미만인 모든 레코드의 수량을 10개로 수정
UPDATE asst
  SET qntt = 10
  WHERE qntt < 10;
-- 자산번호 '1116' 인 레코드를 다음과 같이 수정
-- 구분=S, 단가=999
UPDATE asst
  SET kind = 'S',
      prce = 999
  WHERE numb = '1116';



select * from asst;
----------------------------------
-- 입력
-- 다음과 같은 데이터를 입력하세요
-- 자산번호 1122
-- 자산품명 스피커
-- 자산구분 S
-- 자산단가 1234
-- 자산수량 99
INSERT INTO asst(numb, name, kind, prce, qntt, dept)
  VALUES('1122', '스피커', 'S', '1234', '99', '');
--단가가 100원 미만인 레코드를 삭제
DELETE FROM asst
  WHERE prce < 100;
-- 의자 종류 전부 삭제
DELETE FROM asst
  WHERE name LIKE '%의자%';
----------------------------------
-- 변경
ALTER TABLE asst
  CHANGE kind type CHAR(1);
ALTER TABLE asst
  MODIFY name CHAR(2);
ALTER TABLE asst
  MODIFY name CHAR(30);
ALTER TABLE asst
  MODIFY qntt CHAR(9);
ALTER TABLE asst
  MODIFY name INT;
----------------------------------
-- 삭제
DELETE FROM asst;
DROP TABLE asst;

-- 날짜 및 시간 셀렉트
SELECT NOW();
-- 날짜 및 시간 셀렉트, 서브스트링
SELECT SUBSTR(NOW(), 1, 10);
-- 시간 (HH:MM 만 가져오기)
SELECT SUBSTR(NOW(), 12, 5);
