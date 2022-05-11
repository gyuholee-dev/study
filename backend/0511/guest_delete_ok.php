<?php
session_start();

$no = $_POST['deleteGuest_target'];
$page = $_POST['page'];

$sql = "DELETE FROM guest WHERE no = '$no'";
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
mysqli_query($conn, $sql);

header('Location: guest.php?page='.$page);

