CREATE TABLE inc (
  no INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  content TEXT,
  writer VARCHAR(20),
  writeday VARCHAR(20),
  fname VARCHAR(30),
  hit INT DEFAULT 0
);

CREATE TABLE inc_re (
  no INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  writer VARCHAR(20),
  writeday VARCHAR(20),
  p_no INT
);
