<?php
require_once 'includes/init.php';

$id = '';
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
}

$tablename = array(
  'subject' => '과정',
  'student' => '수강생',
  'examines' => '모의고사',
);

// $dir = 'C:/Workspaces/study/sql/test31';
// $sep = '^';

if (isset($_POST['create'])) {
  $id = $_POST['id'];

  if ($id == 'subject') {
    $createSql = "CREATE TABLE subject
            (
              subjcode CHAR(2) NOT NULL,
              subjname CHAR(20),
              subjkind CHAR(1),
              opendate CHAR(10),
              noperson INT,
              teacname CHAR(10),
              amtprice INT,
              usestate CHAR(1),
              PRIMARY KEY(subjcode)
            )
            ";
  } elseif ($id == 'student') {
    $createSql = "CREATE TABLE student
            (
              subjcode CHAR(2) NOT NULL,
              studnumb CHAR(2) NOT NULL,
              studname CHAR(10),
              studgend CHAR(1),
              phonnumb CHAR(13),
              areaname CHAR(30),
              PRIMARY KEY(subjcode, studnumb)
            )
            ";
  } elseif ($id == 'examines') {
    $createSql = "CREATE TABLE examines
            (
              serialno INT AUTO_INCREMENT,
              subjcode CHAR(2),
              studnumb CHAR(2),
              exam_1st INT,
              exam_2nd INT,
              exam_3rd INT,
              PRIMARY KEY(serialno)
            )
            ";
  } else {
    return false;
  }

  mysqli_query($db, "DROP TABLE $id");
  mysqli_query($db, $createSql);

  // $loadSql = "LOAD DATA 
  //             INFILE '$dir/data/$id.txt'
  //             INTO TABLE $id
  //             FIELDS TERMINATED BY '$sep'
  //             ";
  // mysqli_query($db, $loadSql);

  $msg = $tablename[$id].' 테이블 생성 완료';
  $url = "index.php";
  sendMsg($msg, $url);

}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$tablename[$id]?> 테이블 생성</h3>
<hr>
<!-- contents -->
<strong class="red">
  <?=$tablename[$id]?> 테이블을 생성하시겠습니까?
</strong>
<br><br>
<form method="post">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="submit" name="create" value="Yes">
  <input type="button" value="No" onclick="location.href='index.php'">
</form>

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>
