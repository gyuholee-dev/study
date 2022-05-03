<?php
/* 
CREATE TABLE notice(
	no INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(100),
	content TEXT,
	writer VARCHAR(20),
	writeday VARCHAR(20),
	hit INT DEFAULT 0
); 
*/
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
for ($i=1; $i <=196 ; $i++) { 
  $sql = "INSERT INTO notice 
          (title, content, writer, writeday)
          VALUES
          ('$i 번째 공지시항', '내용없음', '관리자', '2022-05-02') ";
  mysqli_query($conn, $sql);
}
echo "$i 건의 데이터가 입력되었습니다.";
