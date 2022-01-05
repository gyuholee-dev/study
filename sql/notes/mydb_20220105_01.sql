----------------------------------------------------------------
-- home 테이블 생성
-- 테이블명: 가게부(home)
  -- 발생일자(date)
  -- 순번(numb)
  -- 내용(cont)
  -- 구분(kind)
  -- 수입(incm)
  -- 지출(otcm)

CREATE TABLE home
  (
    date CHAR(10) NOT NULL,
    numb CHAR(2) NOT NULL,
    cont CHAR(80),
    kind CHAR(2),
    incm int,
    otcm int,
    PRIMARY KEY(date, numb)
  );

INSERT INTO home
  VALUES
    ('2021-12-10', '1', '잔업수당', '수입', 5000, 0),
    ('2021-12-10', '2', '영화관람', '지출', 0, 100),
    ('2021-12-10', '3', '주부식 구매', '지출', 0, 150),
    ('2021-12-11', '1', '도로비', '지출', 0, 20),
    ('2021-12-11', '2', '공과금 납부', '지출', 0, 10),
    ('2021-12-14', '1', '급여', '수입', 10000, 0),
    ('2021-12-14', '2', '외식', '지출', 0, 15),
    ('2021-12-16', '1', '자동차 주유', '지출', 0, 20),
    ('2021-12-18', '1', '컴퓨터 구매', '지출', 0, 30);

----------------------------------------------------------------
SELECT * FROM home;
-- 1. 자료 추가입력
INSERT INTO home 
  VALUES('2022-01-03', '1', '보너스', '수입', 10000, 0);
INSERT INTO home 
  VALUES('2021-11-30', '1', '외식', '지출', 0, 20);
-- 2. 2021년 12월의 총 수입금 및 총 지출 출력
SELECT SUM(incm), SUM(otcm) FROM home
  WHERE date LIKE '2021-12%';
-- 3. 외식비 총합
SELECT SUM(otcm) FROM home
  WHERE cont = '외식';
-- 4. 지출만 골라서 금액 큰 순서대로
SELECT * FROM home
  WHERE kind = '지출'
  ORDER BY otcm DESC;
-- 5. 수입 레코드 카운트 및 금액 합계
SELECT COUNT(*), SUM(incm) FROM home
  WHERE kind = '수입';
-- 6. 2021년 12월 중에서 지출만 골라 금액 큰 순서대로
SELECT * FROM home
  WHERE date LIKE '2021-12%' AND kind = '지출'
  ORDER BY otcm DESC;
-- 7. 발생일자별로 그룹화하여 각 일자별 레코드 카운트 및 수입합계 지출합계
SELECT date, count(*), SUM(incm), SUM(otcm) FROM home
  GROUP BY date;
-- 8. 내용에 '구매' 를 포함하는 레코드 카운트 및 지출 합계
SELECT COUNT(*), SUM(otcm) FROM home
  WHERE cont LIKE '%구매%';
-- 9. 모든 레코드 수입->지출 순서 및 금액 작은순서
SELECT * FROM home
  ORDER BY kind ASC, incm ASC, otcm ASC;
-- 10. 모든 레코드를 최근날짜순으로, 동일 날짜일 경우 일련번호순
SELECT * FROM home
  ORDER BY date DESC, numb ASC;
-- 11. 지출만 골라서 지출금액 상위 3개만
SELECT * FROM home
  WHERE kind = '지출'
  ORDER BY otcm DESC
  LIMIT 0, 3;