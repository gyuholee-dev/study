create table empl
    (
        numb char(02) not null,
        name char(09),
        gend char(01),
        agee int,
        payy int,
        kind char(06),
        primary key(numb) 
    );

show DATABASE;

DESC empl;

insert into empl(numb, name, gend, agee, payy, kind)
    values('01', '도영해', 'M', '40', '5000', '관리');

SELECT * FROM empl;

insert into empl(numb, name, gend, agee, payy, kind)
    values('02', '김선영', 'F', '33', '4000', '생산');
insert into empl(numb, name, gend, agee, payy, kind)
    values('03', '최동수', 'M', '20', '3000', '관리');
insert into empl(numb, name, gend, agee, payy, kind)
    values('04', '윤진수', 'M', '30', '3500', '관리');
insert into empl(numb, name, gend, agee, payy, kind)
    values('05', '신미라', 'F', '35', '3500', '생산');
insert into empl(numb, name, gend, agee, payy, kind)
    values('06', '정승근', 'M', '29', '5500', '생산');
insert into empl(numb, name, gend, agee, payy, kind)
    values('07', '박정호', 'M', '45', '2900', '관리');
insert into empl(numb, name, gend, agee, payy, kind)
    values('08', '이상철', 'M', '42', '3300', '생산');
insert into empl(numb, name, gend, agee, payy, kind)
    values('09', '진미영', 'F', '36', '4700', '관리');

SELECT * FROM empl;

delete from empl;

insert into empl
    values
    ('01', '도영해', 'M', '40', '5000', '관리'),
    ('02', '김선영', 'F', '33', '4000', '생산'),
    ('03', '최동수', 'M', '20', '3000', '관리'),
    ('04', '윤진수', 'M', '30', '3500', '관리'),
    ('05', '신미라', 'F', '35', '3500', '생산'),
    ('06', '정승근', 'M', '29', '5500', '생산'),
    ('07', '박정호', 'M', '45', '2900', '관리'),
    ('08', '이상철', 'M', '42', '3300', '생산'),
    ('09', '진미영', 'F', '36', '4700', '관리');

SELECT * FROM empl;


----선택

--관리만 선택
SELECT * FROM empl 
    where kind='관리';

--여자만 선택
SELECT * FROM empl 
    where gend='F';

--시급이 5000원 이상 선택
SELECT * FROM empl 
    where payy >= 5000;

--나이가 40세 이하인 사람의 성명과 나이만 선택
SELECT name,agee FROM empl 
    where agee <= 40;

--성별이 여자이면서 직종이 생산인 사람 전부 선택
SELECT * FROM empl 
    WHERE gend='F' AND kind='생산';

--성별이 여자이거나 직종이 생산인 사람 전부 선택
SELECT * FROM empl 
    WHERE gend='F' OR kind='생산';


----정렬

--시급이 적은 순서로 정렬
SELECT * FROM empl
    ORDER BY payy ASC;

--사원번호 역순으로 정렬
SELECT * FROM empl
    ORDER BY numb DESC;

--이름 가나다순서로 정렬
SELECT * FROM empl
    ORDER BY name ASC;

