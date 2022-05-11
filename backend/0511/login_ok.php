<?php
session_start();

$id = $_POST['id'];
$pw = $_POST['pw'];

// testdb, member 테이블 확인
// 데이터 없으면 적당한 계정 생성
// INSERT into member (id, pw) VALUES ('test', '1234');

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "SELECT COUNT(*) AS cnt FROM member WHERE id='$id' AND pw='$pw'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);

if ($row['cnt']) {
    $_SESSION['id'] = $id;
    echo '<script>alert("환영합니다"); location.href="guest.php"</script>';
} else {
    echo '<script>alert("아이디 비밀번호 오류"); history.back(); </script>';
}
