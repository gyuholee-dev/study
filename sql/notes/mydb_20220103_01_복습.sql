-------------------------------------------
SELECT * FROM item;
SELECT * FROM dept;
-------------------------------------------
-------- 기초 복습

-- 셀렉트
SELECT [필드] FROM [테이블];
SELECT 
  SUM(필드), -- 합계
  COUNT()(필드), -- 갯수
  AVG(필드), -- 평균
  DISTINCT(필드), -- 고유
  MAX(필드), -- 최대
  MIN(필드) -- 최저
  FROM [테이블];

SELECT [필드] FROM [테이블]
  WHERE [필드명][연산자][필드값]
  AND(OR) [필드명][연산자][필드깂]
  GROUP BY [필드명],[필드명]
  ORDER BY [필드명] [asc/desc]
  LIMIT [시작열] [열수]
  ;

-- 셀렉트 조인
SELECT [테이블A].[필드], [테이블B].[필드] FROM [테이블A]
  JOIN [테이블B] ON [테이블A].[필드] = [테이블B].[필드];

-- 테이블 크리에이트
CREATE TABLE [테이블]
  (
    [필드명] CHAR(0) NOT NULL, -- 캐릭터, 프라이머리 키 필드는 반드시 NOT NULL
    [필드명] VARCHAR(0), -- 가변 캐릭터
    [필드명] INT, -- 정수
    PRIMARY KEY([첫번째 필드명]) -- 프라이머리 키가 중복될 경우 두개 이상 준다
  );
-- 테이블 알터(열 추가, 삭제)
ALTER TABLE [테이블]
  ADD [필드명] [인자] -- CHAR(), INT...
  MODIFY [필드명] [인자]
  CHANGE [필드명] [필드명] [인자]
  DROP [열]
  ;
-- 테이블 드랍
DROP TABLE [IF EXISTS] [테이블];

-- 레코드 인서트
INSERT INTO [테이블]([필드명],[필드명],[필드명]) -- 필드명 생략가능
  VALUES ([레코드],[레코드],[레코드]);
-- 레코드 업데이트
UPDATE [테이블]
  SET [필드명]=[레코드],
      [필드명]=[레코드]
  WHERE [필드명]=[레코드];
-- 레코드 딜리트
DELETE FROM [테이블]
  WHERE [필드명]=[레코드];
-------------------------------------------
