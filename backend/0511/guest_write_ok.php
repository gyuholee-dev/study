<?php
session_start();

$memo = $_POST['memo'];
$writeday = date('Y-m-d');
$writer = $_SESSION['id'];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "INSERT INTO guest 
        (memo, writeday, writer) 
        VALUES 
        ('$memo', '$writeday', '$writer')";
mysqli_query($conn, $sql);

header('Location: guest.php');
