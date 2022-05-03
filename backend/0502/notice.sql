-- mysql -u root
-- use testdb
CREATE TABLE notice(
	no INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(100),
	content TEXT,
	writer VARCHAR(20),
	writeday VARCHAR(20),
	hit INT DEFAULT 0
);
-- SELECT * FROM notice;

