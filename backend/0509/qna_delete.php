<?php
$no = $_GET["no"];
$step = $_GET["step"];

$title = '삭제된 글입니다.';
$newstep = -1;

if ($step == 1) {
    $title = '삭제된 답글입니다.';
    $newstep = -2;
}

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "UPDATE qna SET
        title = '$title',
        content = NULL,
        writer = '-',
        step = '$newstep'
        WHERE no = '$no'";
// echo $sql;
mysqli_query($conn, $sql);

header("Location: index.php");