<?php
// 모든 파일들(DB포함) 은 읽기(쓰기) 전에 반드시 open 한다
// 작업이 끝나면 close 해주는게 바람직하다

// 파일오픈
// php.net/manual/en/function.fopen.php
$ff = fopen('text/myfile01.txt','r');
// 파일읽기
// https://www.php.net/manual/en/function.fgets.php
fgets($ff, 1000);
// 파일쓰기 fputs = fwrite
// https://www.php.net/manual/en/function.fputs.php
fputs();
// 파일클로즈
// https://www.php.net/manual/en/function.fclose.php
fclose($ff);