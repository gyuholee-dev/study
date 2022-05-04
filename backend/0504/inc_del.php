<?php
// $no = $_GET['no'];
// $filename = $_GET['fname'];
$no = isset($_GET['no']) ? $_GET['no'] : '';
$filename = isset($_GET['fname']) ? $_GET['fname'] : '';
// echo $no."<br>";
// echo $filename."<br>";

$file_dir = $_SERVER['DOCUMENT_ROOT'].'/fileserver/'.$filename;
if (file_exists($file_dir)) {
    unlink($file_dir);
}
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "DELETE FROM inc WHERE no = '$no'";
mysqli_query($conn, $sql);
header('Location: inc.php');
