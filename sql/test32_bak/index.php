<?php
require_once 'includes/init.php';

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h2>프로그램 목록</h2>
<hr>

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
        onclick="location.href='create.php'">
      </td>
      <td>
        <input type="button" value="구매요청 생성" 
        onclick="location.href='create.php'">
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 등록" 
        onclick="location.href='edit.php?action=register'" <?=$disabled?>>
      </td>
      <td>
        <input type="button" value="구매요청 등록" 
        onclick="location.href='create.php'">
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 편집" 
        onclick="location.href='view.php?action=manage'" <?=$disabled?>>
      </td>
      <td>
        <input type="button" value="구매요청 조회" 
        onclick="location.href='create.php'">
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 폐기" 
        onclick="location.href='edit.php?action=dispose'" <?=$disabled?>>
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="고정자산 현황" 
        onclick="location.href='view.php'" <?=$disabled?>>
      </td>
    </tr>

  </table>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>