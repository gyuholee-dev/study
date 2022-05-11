<?php

$title = $_POST["title"];
$content = $_POST["content"];
$writer = "질문자";
$writeday = date("Y-m-d H:i:s");
$step = 0;

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "SELECT IFNULL(MAX(f_no),0)+1 AS f_no FROM qna";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$f_no = $row["f_no"];

$sql2 = "INSERT INTO qna 
        (title, content, writer, writeday, step, f_no)
        VALUES
        ('$title', '$content', '$writer', '$writeday', '$step', '$f_no')";
mysqli_query($conn, $sql2);

header("Location: index.php");
