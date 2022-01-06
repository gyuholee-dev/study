-- 차계부 관리 (carr)
  -- 발생순번 (numb)
  -- 발생일자 (date)
  -- 발생내역 (cont)
  -- 비용 (cost)
  -- 발생장소 (plce)
  -- 비용구분 (kind)
CREATE TABLE carr
  (
    numb INT AUTO_INCREMENT,
    date CHAR(10),
    cont CHAR(60),
    cost INT,
    plce CHAR(30),
    kind CHAR(1),
    PRIMARY KEY(numb)
  );

INSERT INTO carr
  VALUES
    ('1111', '자전거', 500, 3, '보유', 'T'),