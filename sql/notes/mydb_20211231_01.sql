--데이터베이스 확인
show databases;

--데이터베이스 선택
select mydb;

--테이블 확인
show tables;

-------------------------------------------

--테이블 구조 확인
desc empl;

--모든 레코드 선택
SELECT * FROM empl;

-------------------------------------------
---- 함수 sum, count, avg, max, min, distinct ----

--합계: sum 함수
--모든 급료 합계 선택
select sum(payy) from empl;
--모든 급료 합계 선택, 조건 여자
select sum(payy) from empl
    where gend='F';

--갯수: count 함수
--모든 종업원 수
select count(*) from empl;
--나이가 40세 이상인 종업원수
select count(*) from empl
    where agee >= '40';


--평균: avg 함수
--급료 평균
select avg(payy) from empl;
--관리직의 급료 평균
select avg(payy) from empl
    where kind='관리';
--생산직의 급료 평균
select avg(payy) from empl
    where kind='생산';

--최고: max 함수
--급료 최고
select max(payy) from empl;
select name, max(payy) from empl;
--가장 높은 사번
select max(numb) from empl;
--가장 많은 나이, 생산직 조건
select max(agee) from empl
    where kind='생산';

--최저: min 함수
--나이 최저
select min(agee) from empl;

--최고시급과 최저시급 차이 금액?
select max(payy)-min(payy) from empl;

--고유하게 추림: distinct
--직종만 고유하게 선택
select distinct(kind) from empl;
--성별만 고유하게 선택
select distinct(gend) from empl;


--그룹 GROUP BY
--남자 여자 그룹 카운트
select gend, count(*) from empl
    group by gend
    order by gend desc;
--직종별로 그룹, 인원수 카운트, 평균급료
select kind,count(*),avg(payy) from empl
    group by kind;
--성별별로 그룹, 인원수 카운트, 평균급료
select gend,count(*),avg(payy) from empl
    group by gend;
--성별별로 그룹, 성별 인원수 및 평균나이
select gend,count(*),avg(agee) from empl
    group by gend;

--리미트 LIMIT
--전체 목록 다섯개까지만
select * from empl
    limit 0,5;

--급여 많은 순서 세개까지
select name,payy from empl
    order by payy desc
    limit 0,3;


--필드명 별칭 부여
select max(payy)-min(payy) as Diff_Payy from empl;
select
    max(payy) as 최고급여, 
    min(payy) as 최저급여,
    max(payy)-min(payy) as 차이금액 
    from empl;

--와일드카드(%) 사용 (윈도우의 *와 동일)
--where 조건문에  like 를 써야함
--이름이 최로 시작 
select * from empl
    where name like '최%';
--이름이 영으로 끝남
select * from empl
    where name like '%영';
--이름에 영이 포함
select * from empl
    where name like '%영%';


-------------------------------------------
SELECT * FROM empl;

--정렬
--나이 많은 순서대로 정렬
select * from empl
    order by agee desc;
--이름순서대로 정렬
select * from empl
    order by name asc;
--남자 여자 순서, 나이순서
select * from empl
    order by gend desc, agee desc;
--직종순서(관리,생산), 시급 많은 순, 나이 40세 이하 조건
select * from empl
    where agee <= '40'
    order by kind asc, payy desc;

--수정
--번호 1번의 이름을 도용해로 수정
update empl
    set name='도용해',
        gend='F',
        payy='6000'
    where numb='01';
--이름이 진미영의 나이를 37살로 수정
update empl
    set agee='37'
    where name='진미영';
--번호 5번의 나이를 33세로 직종을 관리직으로 수정
update empl
    set agee='33',
        kind='관리'
    where numb='05';
--성별이 여성만 시급을 +555원
update empl
    set payy=payy+555
    where gend='F';
--모든 사람의 나이를 +1
update empl
    set agee=agee+1;
--이름 이상철의 레코드를 삭제
delete from empl
    where name='이상철';
--나이가 40세 이상인 자료 전부 삭제
delete from empl
    where agee>=40;
--남자 레코드를 전부 삭제
delete from empl
    where gend='M';

--테이블 제거
drop table empl;
show tables;

-------------------------------------------
--트랜잭션 관리
--start transaction 트랜잭션 시작
--insert, update, delete 명령에 작용
--rollback 롤백
--commit 확정

--트랜잭션 시작
start transaction;
rollback;
commit;
-------------------------------------------

