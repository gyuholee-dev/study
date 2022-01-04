--새 테이블 dept
--code 2자리 name 한글4자이상

--테이블 생성
create table dept
    (
        code char(2) not null,
        name char(30),
        primary key(code)
    );
show tables;
desc dept;

--레코드 삽입
insert into dept(code,name)
    values
    ('11', '기획실'),
    ('12', '총무부'),
    ('13', '영업부'),
    ('14', '자재부'),
    ('15', '경리부'),
    ('16', '생산부'),
    ('21', '양산공장'),
    ('22', '김해공장'),
    ('23', '진주공장');
select * from dept;

--새 테이블 item
--seqn name type prce qntt loca
create table item
    (
        seqn char(2) not null,
        name char(30),
        type char(1),
        prce int,
        qntt int,
        loca char(1),
        primary key(seqn)
    );
show tables;
desc item;

--레코드 삽입
insert into item
    values
    ('11', '배추', 'V', 3000, 30, 'A'),
    ('12', '사과', 'F', 1000, 25, 'A'),
    ('13', '양파', 'V', 1200, 50, 'B'),
    ('14', '마늘', 'V', 5000, 40, 'A'),
    ('15', '바나나', 'F', 2500, 29, 'B'),
    ('16', '포도', 'F', 1500, 60, 'B'),
    ('17', '수박', 'F', 8000, 45, 'A'),
    ('18', '복숭아', 'F', 800, 35, 'A'),
    ('19', '시금치', 'V', 900, 75, 'B');
select * from item;

-------------------------------------------
--select 조건문 참고
--https://coding-factory.tistory.com/81

--과일(F) 종류수 평균단가 수량합계 출력
select count(*),avg(prce),sum(qntt) from item
    where type='F';
--채소(V) 중에서 가장 비싼 가격 가장 싼 가격 출력
select max(prce),min(prce) from item
    where type='V';
--수량이 50개 이상인 자료의 품목명, 단가, 수량 출력
select name,prce,qntt from item
    where qntt>=50;
--A창고에 있는 각 품목들의 품목명, 단가, 수량, 금액 및 위치 출력
select name,prce,qntt,prce*qntt,loca from item
    where loca='A';
--단가 3000원 이상의 채소만 출력
select * from item
    where prce>='3000' and type='V';
--단가 5000원 이상이거나 수량이 50 이상인것 모든 항목
select * from item
    where prce>='5000' or qntt>='50';
--A창고에 있는것들을 수량이 많은 순서대로 출력
select * from item
    where loca='A'
    order by qntt desc;
--채소(V) - 과일(F) 순서 및 비싼순서대로
select * from item
    order by type desc, prce desc;
--구분(type)별로 그룹하여 각 그룹의 품목갯수, 평균단가, 수량합계 출력
select type,count(*),avg(prce),sum(qntt) from item
    group by type;
--위치별로 그룹화하여 각 위치별 품목종류수, 합계수량
select loca,count(type),sum(qntt) from item
    group by loca;

-------------------------------------------
-- 테이블 변경
select * from item;
-- dept 열 추가
alter table item
    add dept char(2);
-- dept 업데이트
update item
    set dept='11';
update item
    set dept='12'
    where seqn='12'
        or seqn='13'
        or seqn='17';
update item
    set dept='13'
    where seqn='14'
        or seqn='15';
update item
    set dept='14'
    where seqn='16'
        or seqn='18';
-- dept 열 삭제
alter table item
    drop dept;
-- dept 업데이트
update item
    set dept='12'
    where seqn='12'
        or seqn='15'
        or seqn='19';
update item
    set dept='13'
    where seqn='13'
        or seqn='14';
update item
    set dept='14'
    where seqn='16'
        or seqn='17';
update item
    set dept='15'
    where seqn='18';
----------------------------------
-- 테스트
select * from item;
-- 관리품목 정렬 카운트
select dept, count(*) from item
    ->     group by dept;
-- 품명에 '도' 가 포함된걸 선택
select * from item
    where name like '%도%';
-- 다음 레코드 새로 추가
    -- 품목번호 '20'
    -- 품목명 '오렌지'
    -- 타입 'F'
    -- 수량 30
    -- 위치 'B'
    -- 관리부서 '11'
    -- 품목단가 1500
insert into item(seqn,name,type,prce,qntt,loca,dept)
    values('20','오렌지','F',1500,30,'B','11');
-- 품명이 오렌지인 레코드 삭제
delete from item
    where name='오렌지';
-- 위치가 'B' 인 레코드 삭제
delete from item
    where loca='B';
----------------------------------
