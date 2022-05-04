<?php
// 데이터 입력
session_start();

$message = $_POST['message'];
$user = $_SESSION['user'];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "INSERT INTO messages 
        VALUES (NULL, '$user', '$message') ";
mysqli_query($conn, $sql);

?>
