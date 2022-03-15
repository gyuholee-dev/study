CREATE TABLE notice (
  num INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(50),
  writer VARCHAR(20),
  wdate VARCHAR(20),
  content TEXT,
  hit INT DEFAULT 0
);

INSERT INTO notice (title, writer, wdate, content)
VALUES (
  '첫번째 공지사항입니다',
  '관리자',
  '2022-03-15',
  '내용없음'
);

INSERT INTO notice (title, writer, wdate, content)
VALUES (
  '두번째 공지사항입니다',
  '관리자',
  '2022-03-15',
  '내용없음'
);

INSERT INTO notice (title, writer, wdate, content)
VALUES (
  '세번째 공지사항입니다',
  '관리자',
  '2022-03-15',
  '내용없음'
);

INSERT INTO notice (title, writer, wdate, content)
VALUES (
  '네번째 공지사항입니다',
  '관리자',
  '2022-03-15',
  '내용없음'
);

INSERT INTO notice (title, writer, wdate, content)
VALUES (
  '다섯번째 공지사항입니다',
  '관리자',
  '2022-03-15',
  '내용없음'
);