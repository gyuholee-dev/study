<?php
require_once 'init.php';

// 변수
$table = 'salelist';
$tableName = '거래처';
$title = $tableName."별 판매현황 집계";
$fileName = 'view.php';

// 파라메터 처리
$action = 'select';
$page = 1;
$year = '2021';
$month = 'all';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['year'])) {
  $year = $_REQUEST['year'];
}
if (isset($_REQUEST['month'])) {
  $month = $_REQUEST['month'];
}

// 카테고리
$comp = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['comp'])) {
  $comp = $_REQUEST['comp'];
}

// url 기본 파라메터
$urlParam = "&page=$page&year=$year&month=$month";
$linkUrlParam = "?action=$action$urlParam";

// WHERE 처리
if ($comp !== 'all') {
  $whereSql .= "AND comp = '$comp' "; 
}

// 거래처 리스트
$compList = array();
$sql = "SELECT DISTINCT(comp) AS comp
        from $table ORDER BY comp ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($compList, $a['comp']);
}

// SELECT 처리
$sql = "SELECT 
        prod, 
        SUM(prce) AS prces, 
        SUM(qnty) AS qntys,
        (SUM(prce) * SUM(qnty)) AS prces_sum
        FROM $table ";
$sql .= $whereSql;
$sql .= "GROUP BY prod ";
$sql .= "ORDER BY prod ASC ";
// echo $sql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- contents -->
<div class="tbContents">
  <style>
    tr.red td {
      color: red;
      font-weight: bold;
    }
  </style>

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
            <input type="hidden" name="year" value="<?=$year?>">
            <input type="hidden" name="month" value="<?=$month?>">

            <label for='comp'><b>거래처</b> 
            <select name="comp" onchange="changeView()" autofocus>
            <?php
              echo "<option value='all'>전체</option>";
              foreach ($compList as $key => $value) {
                $selected = ($comp == $value)?'selected':'';
                echo "<option value='$value' $selected>$value</option>";
              }
            ?>
            </select></label>
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
      echo "<tr>";
      echo "
        <th>제품명</th>
        <th>총거래횟수</th>
        <th>총거래금액</th>
      ";
      $qntys_total = 0;
      $prces_total = 0;
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $prod = $data['prod'];
        $prces = $data['prces'];
        $qntys = $data['qntys'];
        $prces_sum = $data['prces_sum'];
        $qntys_total += (int)$qntys;
        $prces_total += (int)$prces_sum;

        // 데이터 가공
        $prces = number_format($prces).'원';
        $prces_sum = number_format($prces_sum).'원';

        // 데이터 출력
        echo "
          <tr>
          <td>$prod</td>
          <td class='right'>$qntys</td>
          <td class='right'>$prces_sum</td>
          </tr>
        ";
      }

      $prces_total = number_format($prces_total).'원';
      echo "
        <tr class='red'>
        <td>합계</td>
        <td class='right'>$qntys_total</td>
        <td class='right'>$prces_total</td>
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