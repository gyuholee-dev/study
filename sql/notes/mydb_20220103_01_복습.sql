-------------------------------------------
select * from item;
select * from dept;
-------------------------------------------
-------- 기초 복습

-- 셀렉트
select [필드] from [테이블];
select 
    sum(필드), -- 합계
    count(필드), -- 갯수
    avg(필드), -- 평균
    distinct(필드), -- 고유
    max(필드), -- 최대
    min(필드) -- 최저
    from [테이블];

select [필드] from [테이블]
    where [필드명][연산자][필드값]
    and(or) [필드명][연산자][필드깂]
    group by [필드명],[필드명]
    order by [필드명] [asc/desc]
    limit [시작열] [열수]
    ;

-- 셀렉트 조인
select [테이블A].[필드], [테이블B].[필드] from [테이블A]
    join [테이블B] on [테이블A].[필드] = [테이블B].[필드];

-- 테이블 크리에이트
create table [테이블]
    (
        [필드명] char(0) not null, -- 캐릭터, 첫번째에는 반드시 not null
        [필드명] varchar(0), -- 가변 캐릭터
        [필드명] int, -- 정수
        primary key([첫번째 필드명])
    );
-- 테이블 알터(열 추가, 삭제)
alter table [테이블]
    add [필드명] [인자] -- char(), int...
    modify [필드명] [인자]
    change [필드명] [필드명] [인자]
    drop [열]
    ;
-- 테이블 드랍
drop table [if exists] [테이블];

-- 레코드 인서트
insert into [테이블]([필드명],[필드명],[필드명]) -- 필드명 생략가능
    values ([레코드],[레코드],[레코드]);
-- 레코드 업데이트
update [테이블]
    set [필드명]=[레코드],
        [필드명]=[레코드]
    where [필드명]=[레코드];
-- 레코드 딜리트
delete from [테이블]
    where [필드명]=[레코드];
-------------------------------------------
