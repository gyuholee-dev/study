<?php
$no = $_POST["no"];
$title = $_POST["title"];
$content = $_POST["content"];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');

$sql = "UPDATE qna SET title='$title', content='$content' WHERE no='$no'";
mysqli_query($conn, $sql);

header("Location: index.php");
