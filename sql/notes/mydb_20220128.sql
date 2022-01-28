/* group 그룹
code -- PK
name
comp
date
*/

CREATE TABLE grop
(
  code CHAR(2) NOT NULL,
  name CHAR(12),
  comp CHAR(20),
  date CHAR(10),
  PRIMARY KEY(code)
);

/*
11/스텔라/디엔터테인먼트파스칼/2011-05-15
12/씨스타/스타쉽엔터테인먼트/2010-01-30
13/원더걸스/JYP엔터테인먼트/2007-10-15
14/크레용팝/크롬엔터테인먼트/2012-07-20
15/걸스데이/드림티엔터테인먼트/2010-04-30
16/에이핑크/플랜에이엔터테인먼트/2011-03-11
17/카라/DSP미디어/2007-10-15
*/

LOAD DATA INFILE 'C:/Workspaces/study/sql/test28/data/grop.txt'
INTO TABLE grop
FIELDS TERMINATED BY '/';

/* girl 걸
code -- PK 코드
numb --PK 순번
name -- 멤버명
plce -- 출신지역
date -- 생년월일
*/

CREATE TABLE girl
(
  code CHAR(2) NOT NULL,
  numb CHAR(2) NOT NULL,
  name CHAR(12),
  plce CHAR(2),
  date CHAR(10),
  PRIMARY KEY(code, numb)
);

/*
11/01/효은/
11/02/민희/
11/03/소영/
11/04/전율/

12/01/효린/
12/02/보라/
12/03/소유/
12/04/다솜/

13/01/유빈/
13/02/예은/
13/03/선미/
13/04/혜림/

14/01/엘린/
14/02/소율/
14/03/금미/
14/04/초아/
14/05/웨이/

15/01/소진/
15/02/유라/
15/03/민아/
15/04/혜리/

16/01/박초롱/
16/02/윤보미/
16/03/정은지/
16/04/손나은/
16/05/김남주/
16/06/오하영/

17/01/박규리/
17/02/한승연/
17/03/구하라/
17/04/허영지/
*/

LOAD DATA INFILE 'C:/Workspaces/study/sql/test28/data/girl.txt'
INTO TABLE girl
FIELDS TERMINATED BY '/';