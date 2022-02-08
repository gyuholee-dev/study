<?php
require_once 'includes/init.php';

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>우유 대리점 관리 시스템</h3>
<hr>
<!-- contents -->
<div class="tbContents">
<table class="headers" cellpadding="3" cellspacing="0">
  <tr>
    <th width="120">테이블 생성</th>
    <th width="120">제품 관리</th>
    <th width="120">판매원 관리</th>
  </tr>
  <tr>
    <td>
      <input type="button" value="제품마스터" 
      onclick="location.href='itemmast_create.php'">
    </td>
    <td>
      <input type="button" value="제품등록-A" 
      onclick="location.href='itemmast_insertA.php'">
    </td>
    <td>
      <input type="button" value="판매원등록-A" 
      onclick="location.href='salesman_insertA.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="판매원마스터" 
      onclick="location.href='salesman_create.php'">
    </td>
    <td>
      <input type="button" value="제품등록-B" 
      onclick="location.href='itemmast_insertB.php'">
    </td>
    <td>
      <input type="button" value="판매원등록-B" 
      onclick="location.href='salesman_insertB.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="제품입고" 
      onclick="location.href='inntran_create.php'">
    </td>
    <td>
      <input type="button" value="제품 관리" 
      onclick="location.href='itemmast_edit.php'">
    </td>
    <td>
      <input type="button" value="판매원 관리" 
      onclick="location.href='salesman_edit.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="제품출고" 
      onclick="location.href='outtran_create.php'">
    </td>
    <td>
      
    </td>
    <td>
      
    </td>
  </tr>

  <tr>
    <td colspan="3"></td>
  </tr>

  <tr>
    <th width="120">입고 관리</th>
    <th width="120">출고 관리</th>
    <th width="120">각종 자료 조회</th>
  </tr>
  <tr>
    <td>
      <input type="button" value="입고등록-A" 
      onclick="location.href='inntran_insertA.php'">
    </td>
    <td>
      <input type="button" value="출고등록-A" 
      onclick="location.href='outtran_insertA.php'">
    </td>
    <td>
      <input type="button" value="월간 일자별 입고" 
      onclick="location.href='view_inntran_days.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="입고등록-B" 
      onclick="location.href='inntran_insertB.php'">
    </td>
    <td>
      <input type="button" value="출고등록-B" 
      onclick="location.href='outtran_insertB.php'">
    </td>
    <td>
      <input type="button" value="월간 제품별 입고" 
      onclick="location.href='view_inntran_items.php'">
    </td>
  </tr>
  <tr>
    <td>
      <input type="button" value="입고 관리" 
      onclick="location.href='inntran_edit.php'">
    </td>
    <td>
      <input type="button" value="출고 관리" 
      onclick="location.href='outtran_edit.php'">
    </td>
    <td>
      <input type="button" value="조회-3" 
      onclick="location.href='view_.php'" disabled>
    </td>
  </tr>

</table>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>