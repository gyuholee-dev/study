<?php
require_once 'includes/init.php';

?>
<!-- html -->
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<h2 class="title">프로그램 목록</h2>
<!-- <hr> -->

<!-- view.php (select, manage) -->
<!-- edit.php (update, insert, delete) -->

<!-- contents -->
<div class="tbContents">
  <?php
    // 테이블 존재 확인
    $disabled = 'disabled';
    $sql = "SHOW TABLES LIKE 'fixasset'";
    $res = mysqli_query($db, $sql);
    if (mysqli_num_rows($res) > 0) {
      $disabled = '';
    }
  ?>
  <style>
    input[type=button] {
      min-width: 120px;
    }
  </style>
  <table class="headers" cellpadding="3" cellspacing="0">
    <tr>
      <td>
        <input type="button" value="고정자산 생성" 
        onclick="location.href='apps/fixasset/create.php'">
      </td>
      <td>
        <input type="button" value="구매요청 생성" 
        onclick="location.href='apps/requestt/create.php'">
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 등록" 
        onclick="location.href='apps/fixasset/edit.php?action=register'" <?=$disabled?>>
      </td>
      <td>
        <input type="button" value="구매요청 등록" 
        onclick="location.href='apps/requestt/edit.php?action=register'" <?=$disabled?>>
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 관리" 
        onclick="location.href='apps/fixasset/view.php?action=manage'" <?=$disabled?>>
      </td>
      <td>
        <input type="button" value="구매요청 관리" 
        onclick="location.href='apps/requestt/view.php?action=manage'" <?=$disabled?>>
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 폐기" 
        onclick="location.href='apps/fixasset/edit.php?action=dispose'" <?=$disabled?>>
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 현황" 
        onclick="location.href='apps/fixasset/view.php'" <?=$disabled?>>
      </td>
      <td>
        <input type="button" value="구매요청 현황" 
        onclick="location.href='apps/requestt/view.php'" <?=$disabled?>>
      </td>
    </tr>

  </table>
</div>
<!-- contents -->
</body>
</html>