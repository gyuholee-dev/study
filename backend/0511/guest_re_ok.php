<?php
session_start();

$memo = $_POST['re'];
$writer = $_SESSION['id'];
$p_no = $_POST['p_no'];
$page = $_POST['page'];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "INSERT INTO guest_re (memo, writer, p_no) 
        VALUES ('$memo', '$writer', '$p_no')";
mysqli_query($conn, $sql);

header('Location: guest.php?page='.$page);

