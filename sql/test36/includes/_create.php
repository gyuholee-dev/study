<?php
// 서브밋 입력시
if (isset($_POST['submit']) && $do == 'create') {

  // 테이블 드랍
  $sql = "DROP TABLE IF EXISTS cousmast ";
  console_log($sql);
  mysqli_query($db, $sql);
  $sql = "DROP TABLE IF EXISTS traineee ";
  console_log($sql);
  mysqli_query($db, $sql);
  $sql = "DELETE FROM code WHERE cod1 = '18' ";
  console_log($sql);
  mysqli_query($db, $sql);

  // 테이블 크리에이트
  $sql = "CREATE TABLE cousmast (
            couscode CHAR(2) NOT NULL,
            cousname CHAR(30),
            cousfrom CHAR(10),
            coustoto CHAR(10),
            cousdays INT,
            coustime INT,
            noperson INT,
            PRIMARY KEY (couscode)
          )";
  console_log($sql);
  mysqli_query($db, $sql);
  $sql = "CREATE TABLE traineee (
            couscode CHAR(2) NOT NULL,
            studnumb CHAR(2),
            studname CHAR(10),
            studgend CHAR(1),
            cellphon CHAR(13),
            addresss VARCHAR(96),
            qualdate CHAR(10),
            qualcode CHAR(2),
            jobbdate CHAR(10),
            jobbcode CHAR(4),
            PRIMARY KEY (couscode, studnumb)
          )";
  console_log($sql);
  mysqli_query($db, $sql);

  // 레코드 임포트
  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test36/data/cousmast.txt'
          INTO TABLE cousmast
          FIELDS TERMINATED BY '^'
          (couscode, cousname, cousfrom, coustoto, 
          cousdays, coustime, noperson, @end)
          ";
  console_log($sql);
  mysqli_query($db, $sql);
  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test36/data/traineee.txt'
          INTO TABLE traineee
          FIELDS TERMINATED BY '^'
          (couscode, studnumb, studname, studgend, 
          cellphon, addresss, qualdate, qualcode, jobbdate, jobbcode, @end)
          ";
  console_log($sql);
  mysqli_query($db, $sql);
  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test36/data/qualific.txt'
          INTO TABLE code
          FIELDS TERMINATED BY '^'
          (cod1, cod2, name, used, @end)
          ";
  console_log($sql);
  mysqli_query($db, $sql);

  $msg = "$tableName 테이블 생성 완료";
  $url = "start.php";
  sendMsg($msg, $url);
  
}

?>
<div class="tbContents">
  <strong class="red" style="font-size:125%">
    <?=$tableName?> 테이블을 생성하겠습니까?
  </strong>
  <br>
  <br>
  <form method="post">
    <input type="hidden" name="do" value="create">
    <input type="submit" class="active" name="submit" value="Yes">
    <input type="button" value="No"
      onclick="location.href='start.php'">
  </form>
</div>