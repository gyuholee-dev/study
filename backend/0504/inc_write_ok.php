<?php
$writer = $_POST['writer'];
$title = $_POST['title'];
$content = $_POST['content'];
$writeday = date("Y-m-d H:i:s");
$fname = basename($_FILES['userfile']['name']);
// echo $writer."<br>";
// echo $title."<br>";
// echo $content."<br>";
// echo $writeday."<br>";
// echo $fname."<br>";

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/fileserver/';
@mkdir($uploaddir); // 디렉토리 생성
// echo $uploaddir;
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
// echo chown($uploadfile, 'user'); // 윈도우에서는 안됨
// echo chmod($uploadfile, 0775); // 윈도우에서는 안됨
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "INSERT INTO inc 
        (title, content, writer, writeday, fname) 
        VALUES 
        ('$title', '$content', '$writer', '$writeday', '$fname')";
mysqli_query($conn, $sql);
header('Location: inc.php');