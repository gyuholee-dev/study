<?php
$p_no = $_POST['p_no'];
$comment = $_POST['comment'];
// $writer = $_SESSION['id'];
$writer = "궁금이";
$writeday = date("Y-m-d H:i:s");

$conn = mysqli_connect("localhost", "root", "", "testdb");
$sql = "INSERT INTO inc_re 
        (content, writer, writeday, p_no)
        VALUES 
        ('$comment', '$writer', '$writeday', '$p_no') ";
mysqli_query($conn, $sql);
header("Location: inc_content.php?no=$p_no");