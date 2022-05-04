<?php
$no = $_GET['no'];
$p_no = $_GET['p_no'];

$conn = mysqli_connect("localhost", "root", "", "testdb");
$sql = "SELECT * FROM inc_re WHERE no = '$no'";
mysqli_query($conn, $sql);
$res = mysqli_query($conn, $sql);
$a = mysqli_fetch_array($res);

// if ($a['writer'] == $_SESSION['id']) {
if ($a['writer'] == "궁금이") {
    $sql = "DELETE FROM inc_re WHERE no = '$no'";
    mysqli_query($conn, $sql);
}
header("Location: inc_content.php?no=$p_no");
