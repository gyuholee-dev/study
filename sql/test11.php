<?php
ini_set('display_errors', 0);
include 'include/head.inc';

//// 텍스트파일 순차 읽기 쓰기
// inform01.txt 텍스트파일 내용
"
supp
7
supplier.txt
";

// 읽을 파일 오픈
$ff = fopen('text/inform01.txt', 'r');
// 한줄씩 순차 읽기 -> 변수화
$tblname = fgets($ff, 999);
$colnumb = fgets($ff, 999);
$outname = fgets($ff, 999);
fclose($ff);

echo "$tblname / $colnumb / $outname";
echo '<br>';

// DB 조회
$sql = "SELECT * FROM $tblname";
$res = mysqli_query($db, $sql);

// 쓸 파일 오픈
$ff = fopen('text/'.$outname, 'w');
// 한줄씩 순차 쓰기

$ni = 0;
$num = mysqli_num_rows($res);
while ($a = mysqli_fetch_array($res)) {
    /* $ss = '';
    for ($i=0; $i<$colnumb; $i++){
        $ss = $ss.$a[$i].'~';
    }
    $ss = $ss."\r";
    // echo $ss;
    fwrite($ff, $ss); */

    $ss = '';
    for ($i=0; $i<$colnumb; $i++){
        $ss = $ss.$a[$i];
        if ($i != $colnumb-1) {
            $ss = $ss.'~';
        }
    }
    if ($ni != $num-1) {
        $ss = $ss."\r";
    }
    $ni++;
    // echo $ss;
    fwrite($ff, $ss);
}
fclose($ff);

echo '작업 완료';