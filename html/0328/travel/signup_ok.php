<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, "testdb");

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email1'].'@'.$_POST['email2'];
$pw = $_POST['pw1'];
$gender = $_POST['gender'];
$hobby1 = (isset($_POST['hobby1']))?$_POST['hobby1']:'';
$hobby2 = (isset($_POST['hobby2']))?$_POST['hobby2']:'';
$hobby3 = (isset($_POST['hobby3']))?$_POST['hobby3']:'';
$hobby4 = (isset($_POST['hobby4']))?$_POST['hobby4']:'';
$hobby5 = (isset($_POST['hobby5']))?$_POST['hobby5']:'';
$grade = $_POST['grade'];
$comment = $_POST['comment'];

echo "
  id : $id<br>
  name : $name<br>
  email: $email<br>
  pw : $pw<br>
  gender : $gender<br>
  hobby1 : $hobby1<br>
  hobby2 : $hobby2<br>
  hobby3 : $hobby3<br>
  hobby4 : $hobby4<br>
  hobby5 : $hobby5<br>
  grade : $grade<br>
  comment : $comment<br>
";

$sql = "INSERT INTO member 
        VALUES (
          '$id', '$name', '$email', '$pw', '$gender', 
          '$hobby1', '$hobby2', '$hobby3', '$hobby4', '$hobby5', 
          '$grade', '$comment'
        )";
mysqli_query($db, $sql);

echo "
  <script>
    alert('회원가입을 축하합니다. 로그인 화면으로 이동합니다');
    location.href='login.php';
  </script>
";
