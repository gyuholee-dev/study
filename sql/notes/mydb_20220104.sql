----------------------------------------------------------------
-- lect 테이블 생성
-- 테이블명: 문화강좌(lect)
  -- 강좌코드(code)
  -- 강좌명(name)
  -- 구분(kind)
  -- 시간(hour)
  -- 모집인원(inwn)
  -- 수강료(feee)
  -- 담당교사(teac)

CREATE TABLE lect
  (
    code CHAR(3) NOT NULL,
    name CHAR(20),
    kind CHAR(1),
    hour INT,
    inwn INT,
    feee INT,
    teac CHAR(3),
    PRIMARY KEY(code)
  );

INSERT INTO lect
  VALUES
    ('111', '지점토 공예', 'H', 50, 20, 50000, '윤정혜'),
    ('112', '종이접기', 'H', 60, 15, 50000, '신정기'),
    ('113', '쉬운 엑셀', 'S', 80, 10, 70000, '도영해'),
    ('114', '클래식기타', 'H', 100, 8, 80000, '정철훈'),
    ('115', '파워포인트', 'S', 70, 12, 90000, '도영해'),
    ('116', '재즈기타', 'H', 120, 13, 80000, '정철훈'),
    ('117', '고적답사', 'H', 40, 10, 100000, '박상진'),
    ('118', '퀼트공예', 'H', 30, 20, 60000, '윤정혜'),
    ('119', 'HTML 기초', 'S', 90, 15, 40000, '도영해');

----------------------------------------------------------------
-- 수강시간(hour)이 90시간 이상인 레코드 전부 셀렉트
SELECT * FROM lect
  WHERE hour >= 90;
-- 담당교사가 도영해인 강좌 갯수 및 시간 총합계
SELECT COUNT(*), SUM(hour) FROM lect
  WHERE teac = '도영해';
-- 취미반(kind = H) 의 강좌명, 구분, 모집인원, 수강료, 수입금액
SELECT name, kind, inwn, feee, feee * inwn FROM lect
  WHERE kind = 'H';
-- 수강료가 90000 이상인 모든 레코드
SELECT * FROM lect
  WHERE feee >= 90000;
-- 구분이 취미(H) 이면서 모집인원이 15명 이상인 레코드
SELECT * FROM lect
  WHERE kind = 'H' AND inwn >= 15;
-- 구분이 취미(H) 이거나 시간이 90시간 이상인 레코드
SELECT * FROM lect
  WHERE kind = 'H' OR hour >= 90;
-- 교사 이름에 '정' 자 포함
SELECT * FROM lect
  WHERE teac LIKE '%정%';
-- 가장 큰 강좌코드
SELECT MAX(code) FROM lect;
-- 전문반(S) 의 강좌갯수 및 모집인원 합계
SELECT COUNT(*), SUM(inwn) FROM lect
  WHERE kind = 'S';
-- 모집인원을 다 채웠을때 전문반의 수강료 총합계
SELECT inwn * SUM(feee) FROM lect
  WHERE kind = 'S';
-- 취미반(H)의 가장 비싼 수강료와 가장 싼 수강료의 차액
SELECT MAX(feee) - MIN(feee) FROM lect
  WHERE kind = 'H';
-- 강좌명을 가나다순으로 출력
SELECT * FROM lect
  ORDER BY name;
-- 담당교사 도영해만 골라서 시간 많은 순서대로 출력
SELECT * FROM lect
  WHERE teac = '도영해'
  ORDER BY hour DESC;
-- 취미반 -> 전문반 순으로 출력하되 같은 구분일 경우 모집인원이 많은 순서대로
SELECT * FROM lect
  ORDER BY kind ASC, inwn DESC;
-- 담당교사명 순으로 출력하되 같은 교사일 경우 시간 많은 순서대로
SELECT * FROM lect
  ORDER BY teac ASC, hour DESC;
-- 문화강좌에 참여하는 교사명만
SELECT DISTINCT(name) FROM lect;
--구분별(H,S)로 그룹화하여 각각의 강좌수, 모집인원 합계
SELECT kind, COUNT(*), SUM(inwn) FROM lect
  GROUP BY kind;
-- 담당교사별로 그룹화하여 각 교사별로 강좌수 시간수 합계
SELECT teac, COUNT(*), SUM(hour) FROM lect
  GROUP BY teac;
-- 취미과정 중에서 수강료 비싼 순서로 상위 3개
SELECT * FROM lect
  WHERE kind ='H'
  ORDER BY feee DESC
  LIMIT 0, 3;
-- 시간이 작은 순서대로 1~3 까지만
SELECT * FROM lect
  ORDER BY hour ASC
  LIMIT 0, 3;

-- 테이블 우유마스타(milk) 생성 및 데이터 삽입
CREATE TABLE milk
  (
    code CHAR(3) NOT NULL,
    name CHAR(30),
    spec CHAR(20),
    unit CHAR(2),
    prce INT,
    invt INT,
    type CHAR(10),
    PRIMARY KEY(code)
  );
INSERT INTO milk
  VALUES
    ('111', '백색시유', '200ml', 'EA', 500, 150, '시유'),
    ('112', '백색시유', '500ml', 'EA', 900, 80, '시유'),
    ('113', '백색시유', '1000ml', 'EA', 2000, 60, '시유'),
    ('114', '초코우유', '200ml', 'EA', 600, 40, '가공유'),
    ('115', '밤맛우유', '200ml', 'EA', 700, 30, '가공유'),
    ('116', '바나나우유', '200ml', 'EA', 800, 50, '가공유'),
    ('117', '요구르트1', '80ml', 'BX', 150, 350, '액상'),
    ('118', '요구르트2', '120ml', 'BX', 650, 160, '호상'),
    ('119', '오렌지쥬스', '180ml', 'ST', 1200, 25, '주스');
