<?php
require_once 'includes/init.php';

$action = 'select';
$title = '고정자산 현황';

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = '고정자산 관리';
}



$sql = "SELECT * FROM fixasset";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <div class="tbMenu">
    <form method="get">
      <table class="inner" width="100%">
        <tr>
          <td class="left">
            <select name="asststat">
              <option value="">전체</option>
              <option value="Y">사용중</option>
              <option value="N">폐기</option>
            </select>
          </td>
          <td class="right">
            <input type="button" value="초기화" 
            onclick="location.href='view.php'">
            <input type="button" value="메뉴" 
            onclick="location.href='index.php'">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <table cellpading="3" cellspacing="1">
    <tr>
      <th>번호</th>
      <th>자산명</th>
      <th>구입일자</th>
      <th>단가</th>
      <th>수량</th>
      <th>부서</th>
      <th>폐기</th>
      <th>폐기일자</th>
      <th>폐기사유</th>
    </tr>

  </table>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>