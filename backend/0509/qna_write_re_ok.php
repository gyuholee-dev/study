<?php
$title = $_POST["title"];
$content = $_POST["content"];
$writeday = date("Y-m-d H:i:s");
$writer = "답변자";
$f_no = $_POST["f_no"];
$step = 1;

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "INSERT INTO qna
        (title, content, writer, writeday, step, f_no)
        VALUES
        ('$title', '$content', '$writer', '$writeday', '$step', '$f_no')";
mysqli_query($conn, $sql);

header("Location: index.php");
