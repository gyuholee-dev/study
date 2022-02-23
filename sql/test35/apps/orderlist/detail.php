<?php
require_once 'init.php';

// 변수
$table = 'orderlist';
$tableName = '유기농식품';
$title = "<i class='xi-list-dot'></i> $tableName"." 주문 집계표";
$fileName = 'detail.php';

// 파라메터 처리
$action = 'select';
$page = 1;
$comp = 'all';
$subj = 'all';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['comp'])) {
  $comp = $_REQUEST['comp'];
}
if (isset($_REQUEST['subj'])) {
  $subj = $_REQUEST['subj'];
}

// 카테고리
$comp = 'all';
$whereSql = '';
if (isset($_REQUEST['comp'])) {
  $comp = $_REQUEST['comp'];
}

// url 기본 파라메터
$urlParam = "&page=$page&comp=$comp&subj=$subj";
$linkUrlParam = "?action=$action$urlParam";

// WHERE 처리
if ($comp !== 'all') {
  $whereSql .= "WHERE comp = '$comp' "; 
}

// 주문처 리스트
$compList = array();
$sql = "SELECT DISTINCT(comp) AS comp
        from $table ORDER BY comp ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($compList, $a['comp']);
}

// 품목 리스트
$subjList = array();
$sql = "SELECT DISTINCT(subj) AS subj
        from $table ORDER BY subj ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($subjList, $a['subj']);
}

// 데이터셋
$dataSet = array();
foreach ($subjList as $s) {
  $dataSet[$s] = [];
}
$sql = "SELECT subj, 
        SUM(prce) AS prce,
        SUM(qnty) AS qnty,
        SUM(prce*qnty) AS sale
        FROM orderlist
        $whereSql
        GROUP BY subj ";
// echo $sql;
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $dataSet[$a['subj']] = [
    'prce' => $a['prce'],
    'qnty' => $a['qnty'],
    'sale' => $a['sale']
  ];
}
console_log($dataSet);

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- contents -->
<div class="tbContents">

  <div class="tbMenu">
    <script>
      function changeView() {
        var form = document.getElementById('tbmenu');
        form.submit();
      }
    </script>
    <table class="inner" width="100%">
      <tr>
        <td class="left">
          <form id="tbmenu" method="get">
            <input type="hidden" name="action" value="<?=$action?>">
            <input type="hidden" name="page" value="<?=$page?>">
            <!-- <input type="hidden" name="comp" value="<?=$comp?>"> -->
            <input type="hidden" name="subj" value="<?=$subj?>">
            <?php
              echo "<label for='cont'><b>주문처</b> ";
              echo "<select name='comp' onchange='changeView()'>";
              echo "<option value='all'>전체</option>";
              foreach ($compList as $key => $value) {
                $selected = ($comp == $value)?'selected':'';
                echo "<option value='$value' $selected>$value</option>";
              }
            ?>
          </form>
        </td>
        <td class="right" style="vertical-align:bottom;">
          <input type="button" value="뒤로" 
          onclick="location.href='view.php<?=$linkUrlParam?>'">
        </td>
      </tr>
    </table>
  </div>

  <div id="tableWrap">
  <table width="100%" cellpading="3" cellspacing="1">
    <?php 
      // 헤더
      echo "<tr class='header'>";
      echo "
        <th>품목</th>
        <th>단가</th>
        <th>주문량</th>
        <th>주문금액</th>
      ";

      $total_prce = 0;
      $total_qnty = 0;
      $total_sale = 0;
      foreach ($dataSet as $key => $data) {
        if (count($data)>0) {
          // 데이터 선언
          $prce = number_format($data['prce']).'원';
          $qnty = $data['qnty'];
          $sale = number_format($data['sale']).'원';

          $total_prce += $data['prce'];
          $total_qnty += $data['qnty'];
          $total_sale += $data['sale'];
        } else {
          $prce = '';
          $qnty = '';
          $sale = '';
        }

        // 데이터 출력
        echo "
          <tr>
            <td>$key</td>
            <td class='right'>$prce</td>
            <td class='right'>$qnty</td>
            <td class='right'>$sale</td>
          </tr>
        ";
      }

      $total_prce = number_format($total_prce).'원';
      $total_sale = number_format($total_sale).'원';;

      echo "
        <tr class='yellow'>
          <td>합계</td>
          <td class='right'>$total_prce</td>
          <td class='right'>$total_qnty</td>
          <td class='right'>$total_sale</td>
        </tr>
      ";

    ?>
  </table>
  </div>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="72">

      </td>
      <td>
      
      </td>
      <td class="right" width="72">
      
      </td>
      </tr>
    </table>
  </div>


</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>