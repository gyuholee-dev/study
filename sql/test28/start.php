<?php
require_once 'includes/init.php';

$action = 'start';
$title = $tableName.' 관리';

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<div class="tbContents">
<table class="headers" cellpadding="3" cellspacing="0">
  <tr>
    <th width="120">테이블 생성</th>
    <th width="120">데이터 등록</th>
    <th width="120">데이터 조회</th>
  </tr>
  <tr>
    <td>
      <input type="button" value="그룹 생성" 
      onclick="location.href='group_create.php'">
    </td>
    <td>
      <input type="button" value="그룹 등록" 
      onclick="location.href='group_insert.php'">
    </td>
    <td>
      <input type="button" value="그룹 조회" 
      onclick="location.href='group_select.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="멤버 생성" 
      onclick="location.href='member_create.php'">
    </td>
    <td>
      <input type="button" value="멤버 등록" 
      onclick="location.href='member_insert.php'">
    </td>
    <td>
      <input type="button" value="멤버 조회" 
      onclick="location.href='member_select.php'">
    </td>
  </tr>
</table>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>