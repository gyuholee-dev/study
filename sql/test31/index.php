<?php
require_once 'includes/init.php';

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>프로그램 목록</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <style>
    input[type=button] {
      min-width: 120px;
    }
  </style>
  <table class="headers" cellpadding="3" cellspacing="0">
    <tr>
      <th colspan="3">
        테이블 관리
      </th>
    </tr>
    <tr>
      <td>
        <input type="button" value="과정 생성" 
        onclick="location.href='create_table.php?id=subject'">
      </td>
      <td>
        <input type="button" value="수강생 생성" 
        onclick="location.href='create_table.php?id=student'">
      </td>
      <td>
        <input type="button" value="모의고사 생성" 
        onclick="location.href='create_table.php?id=examines'">
      </td>
    </tr>

    <tr>
      <th width="120">과정 관리</th>
      <th width="120">수강생 관리</th>
      <th width="120">모의고사 관리</th>
    </tr>
    <tr>
      <td>
        <input type="button" value="과정 관리" 
        onclick="location.href='view_subject.php?action=edit'">
      </td>
      <td>
        <input type="button" value="수강생 관리" 
        onclick="location.href='view_student.php?action=edit'">
      </td>
      <td>
        <input type="button" value="모의고사 관리" 
        onclick="location.href='view_examines.php?action=edit'">
      </td>
    </tr>
    <tr>
      <td>
        <input type="button" value="과정 관리" 
        onclick="location.href='#.php'" disabled>
      </td>
      <td>
        <input type="button" value="수강생 관리" 
        onclick="location.href='#.php'" disabled>
      </td>
      <td>
        <input type="button" value="모의고사 관리" 
        onclick="location.href='#.php'" disabled>
      </td>
    </tr>
    <tr>
      <th colspan="3">
        자료 조회
      </th>
    </tr>
    <tr>
      <td>
        <input type="button" value="개설과정 현황" 
        onclick="location.href='view_subject.php'">
      </td>
      <td>
        <input type="button" value="수강학생 현황" 
        onclick="location.href='view_student.php'">
      </td>
      <td>
        <input type="button" value="모의고사 성적" 
        onclick="location.href='view_examines.php'">
      </td>
    </tr>

  </table>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>