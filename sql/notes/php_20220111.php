<?php
// SAM File (Sequantial Access Method File) = 순차 파일
// -- 카세트테이프처럼 처음부터 순차적으로 읽어들여야 함.
// 특징: 
// -- 절대로 안 깨어진다
// -- Read/Write 속도가 대단히 빠르다

// ISAM File (Indexed Access Method File) = 색인 +
// -- 원하는 위치 어디든지 찾아가 읽어들일수 있음
// R - DB


// 파일오픈
$fi = fopen('text/myfile01.txt', 'r'); // 리드
$f2 = fopen('text/myfile01.txt', 'w'); // 라이트

// 파일읽기
$ss1 = fgets($f1, 1000);
echo $ss1;

// 행이 끝날때까지 반복문: End of File
while (!feof($f1)) {
    $ss1 = fgets($f1, 1000);
    echo $ss1;
}

// 개행문자
// "\n" , "\r"

// 구분자 Delimiter
// 구분자 ^ : 11^배추^V^3000
explode('^', $str); // '^' 를 기준으로 나눠서 배열로 리턴

// 파일쓰기
fputs($fi, 'string'); //파일 클로즈할때까지, 반복하면 파일내용 계속 추가됨

// 파일클로즈
fclose($f1);