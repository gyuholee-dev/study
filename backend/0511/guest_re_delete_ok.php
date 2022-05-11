<?php
session_start();

$no = $_POST['deleteGuest_re_target'];
$page = $_POST['page'];

$sql = "DELETE FROM guest_re WHERE no = '$no'";
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
mysqli_query($conn, $sql);

header('Location: guest.php?page='.$page);

