-- attendance / attend
-- absence / absent
/* attendance 출석부
  student_num 학번
  student_name 이름
  attend_cond 출석상태
  absent_reason 결석사유
*/
-- 상태: 출석, 결석, 공가, 휴가, 조퇴, 지각
-- 출력화면, 입력화면 만듦

CREATE TABLE attendance (
  student_num INT NOT NULL,
  student_name VARCHAR(20),
  attend_cond CHAR(2),
  absent_reason VARCHAR(100),
  PRIMARY KEY (student_num)
);

INSERT INTO attendance 
(student_num, student_name, attend_cond, absent_reason)
VALUES
(1, '김민홍', '출석', NULL),
(2, '김가현', '결석', '무단결석'),
(3, '구기태', '공가', '병원방문'),
(4, '김성용', '휴가', '물리치료'),
(5, '홍현주', '조퇴', '개인사유');


