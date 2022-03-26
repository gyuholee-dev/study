https://nickjoit.tistory.com/m/144

-- 유저 조회
mysql > use mysql;
mysql > select host, user, password from user;

-- 유저 추가
create user userid@localhost identified by '비밀번호';

-- 원격지에서 접속 권한 추가 
mysql > grant all privileges on DB명.* to userid@'%';
-- host에 '200.100.%' 로 하면 IP주소가 200.100.X.X 로 시작되는 모든 IP에서 원격 접속을 허용한다는 의미
-- host에 '200.100.100.50' 으로 하면 IP주소가 200.100.100.50 인 곳에서만 원격 접속을 허용한다는 의미

-- user 에게 test 데이터베이스 모든 테이블에 대한 권한 부여 
mysql > grant all privileges on test.* to userid@localhost;

-- user 에게 test 데이터베이스 모든 테이블에 select, insert, update 권한 부여
mysql> grant select, insert, update on test.* to user@localhost;


-- user 에게 test 데이터베이스 모든 테이블에 select, insert, update 권한 부여
mysql> grant select, insert, update on test.* to user@localhost;   

-- user 에게 모든 데이터베이스 모든 테이블에 권한 부여
-- 전역 권한은 모두 광범위한 보안문제가 수반되므로 권한을 허용하는 경우 신중해야 함
mysql> grant all privileges on *.* to user@localhost identified by '비밀번호' with grant option;

--사용자에게 부여된 권한 확인
-- userid 와 host명까지 붙여서 검색해야 함
mysql > show grants for test@localhost;

mysql > show grants for test@'%';

mysql > show grants for test@'200.100.100.50';

-- 사용자에게 데이터베이스 사용권한 제거
revoke all on DB명.테이블명 from 사용자ID;

-- 사용자 계정 삭제
mysql > drop user userid@'%';
mysql > drop user userid@localhost;