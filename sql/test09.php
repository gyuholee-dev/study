<?php
// 텍스트 파일 읽고 출력
/* 
$ff = fopen('text/myfile01.txt','r');

while (!feof($ff)) {
    $str = fgets($ff, 1000);
    echo $str.'<br>';
}

fclose($ff);
 */
 
//// 데이터베이스 읽고 파일 저장
/* 
include 'include/head.inc';
$sql = 'SELECT * FROM item';
$res = mysqli_query($db, $sql);

$ff = fopen('text/mydata01.txt', 'w');
while ($a = mysqli_fetch_array($res)) {
    // $str = $a[0].'/'.$a[1].'/'.$a[2].'/'.$a[3]."\n";
    // $str = "$a[0]^$a[1]^$a[2]^$a[3]\r";
    $str = "$a[0]^$a[1]^$a[2]^$a[3]\n";
    // echo $str;
    fwrite($ff, $str);
}

fclose($ff);
echo 'Write Complete <br>';

// 읽어서 출력 확인
$ff = fopen('text/mydata01.txt','r');
while (!feof($ff)) {
    $str = fgets($ff, 1000);
    echo $str.'<br>';
}
 */

//// 카운터 
// text/counter.txt 파일 만들고 0 입력
$ff = fopen('text/counter.txt', 'r');
$no = fgets($ff, 1000);
// echo $no;
fclose($ff);

$no = $no+1;
// echo $no;
$ff = fopen('text/counter.txt', 'w');
fwrite($ff, $no);
fclose($ff);

echo "귀하는 ($no) 번째 방문자입니다.";
