<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

// DB 조회
$sql = "SELECT * FROM supp";
$res = mysqli_query($db, $sql);

// 쓸 파일 오픈
$file = fopen('json/supplier.json', 'w');
// 한줄씩 순차 쓰기

$i = 0;
$num = mysqli_num_rows($res);

fwrite($file, '['."\n");
while ($a = mysqli_fetch_row($res)) {
    $data = array();
    foreach ($a as $key => $value) {
        $data[$key] = $value;
    }
    // print_r($data);
    // echo '<br>';
    $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
    if ($i != $num-1) {
        $data_json = $data_json.','."\n";
    }
    $i++;
    fwrite($file, $data_json);
}
fwrite($file, "\n".']');

fclose($file);

echo '작업 완료';
echo '<br>';

$file = file_get_contents('json/supplier.json');
$data = json_decode($file, true);
// print_r($data);

$cols = count($data[0]);
foreach ($data as $key => $value) {
    $i = 0;
    foreach ($value as $k => $v) {
        echo $v;
        if ($i != $cols-1) {
            echo '^';
        }
        $i++;
    }
    echo '<br>';
}
