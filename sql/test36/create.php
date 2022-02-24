<?php
require_once 'includes/init.php';

// 파일네임
$fileName = 'create.php';

// 타이틀
$title = "$tableName 생성";

?>
<!-- html -->
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" href="styles/xeicon.min.css">
</head>
<body>
<h2 class="title"><i class='xi-list-dot'></i> <?=$title?></h2>
<!-- contents -->
<div class="tbContents">
  <strong class="red" style="font-size:125%">
    <?=$tableName?> 테이블을 생성하겠습니까?
  </strong>
  <br>
  <br>
  <form method="post">
    <input type="submit" class="active" name="create" value="Yes">
    <input type="button" value="No"
      onclick="location.href='start.php'">
  </form>
</div>
<!-- contents -->
</body>
</html>