<?php
require_once 'includes/init.php';

// 파일네임
$fileName = 'start.php';

if ($action == 'create') {
  // 타이틀
  $title = "$tableName 생성";

  // 서브밋 입력시
  if (isset($_POST['submit'])) {
    if ($do == 'create') {
      $sql = "DROP TABLE IF EXISTS cousmast ";
      mysqli_query($db, $sql);
      console_log($sql);
      $sql = "DROP TABLE IF EXISTS traineee ";
      mysqli_query($db, $sql);
      console_log($sql);

      $sql = "CREATE TABLE cousmast (
                couscode CHAR(2) NOT NULL,
                cousname CHAR(30),
                cousfrom CHAR(10),

                PRIMARY KEY (couscode)
              )";
      console_log($sql);

    }
  }

  // 컨텐츠
  $content = 'includes/_create.php';
}

include 'templates/template.php';

?>
