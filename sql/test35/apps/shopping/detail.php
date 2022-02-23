<?php
require_once 'init.php';

// 변수
$table = 'shopping';
$tableName = '온라인쇼핑몰';
$title = "<i class='xi-list-dot'></i> $tableName";
$fileName = 'detail.php';

// 파라메터 처리
$action = 'selectA';
$page = 1;
$subj = 'all';
$gend = 'all';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'selectA') {
  $title .= " 판매 집계";
} elseif ($action == 'selectB') {
  $title .= " 월간 판매 현황";
}

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['subj'])) {
  $subj = $_REQUEST['subj'];
}
if (isset($_REQUEST['gend'])) {
  $gend = $_REQUEST['gend'];
}

// 카테고리
$stat = 'all';
$whereSql = '';
if (isset($_REQUEST['stat'])) {
  $stat = $_REQUEST['stat'];
}

// url 기본 파라메터
$urlParam = "&page=$page&subj=$subj&gend=$gend";
$linkUrlParam = "?action=$action$urlParam";

// WHERE 처리
if ($gend !== 'all') {
  $whereSql .= "WHERE gend = '$gend' "; 
}

// 품목 리스트
$subjList = array();
$sql = "SELECT DISTINCT(subj) AS subj
        from $table ORDER BY subj ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($subjList, $a['subj']);
}

if ($action == 'selectA') {
  // 데이터셋 A
  $dataSetA = array();
  foreach ($subjList as $key) {
    $dataSetA[$key] = [];
  }
  $sql = "SELECT subj, 
          COUNT(*) AS scnt,
          SUM(qnty) AS qnty,
          SUM(ROUND(prce-(prce/100*dcnt))*qnty) AS sale
          FROM shopping
          $whereSql
          GROUP BY subj ";
  $res = mysqli_query($db, $sql);
  while ($a = mysqli_fetch_assoc($res)) {
    $dataSetA[$a['subj']] = [
      'scnt' => $a['scnt'],
      'qnty' => $a['qnty'],
      'sale' => $a['sale']
    ];
  }
  console_log($dataSetA);

} elseif ($action == 'selectB') {
  // 데이터셋 B
  $dataSetB = array();
  for ($i=1; $i <= 12; $i++) {
    $month = numStr($i, 2);
    $sql = "SELECT subj,
            SUM(ROUND(prce-(prce/100*dcnt))*qnty) AS sale
            FROM shopping
            WHERE date LIKE '2021-$month%' 
            GROUP BY subj ";
    $res = mysqli_query($db, $sql);
    while ($a = mysqli_fetch_assoc($res)) {
      $dataSetB[$month][$a['subj']] = $a['sale'];
    }
  }
  console_log($dataSetB);

}

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- contents -->
<div class="tbContents">

  <? if ($action == 'selectA') { ?>

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
              <input type="hidden" name="subj" value="<?=$subj?>">
              <?php
                $checked = ['all'=>'', 'M'=>'', 'F'=>''];
                $checked[$gend] = 'checked';
              ?>
              <div class="submenu" style="display:inline;">
                <b>성별:</b>
                <label><input onchange="changeView()" <?=$checked['all']?>
                  type="radio" name="gend" value="all">전체</label>
                <label><input onchange="changeView()" <?=$checked['M']?>
                  type="radio" name="gend" value="M">남성</label>
                <label><input onchange="changeView()" <?=$checked['F']?>
                  type="radio" name="gend" value="F">여성</label>
              </div>
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
          <th>제품분류</th>
          <th>판매건수</th>
          <th>판매수량</th>
          <th>판매금액</th>
        ";

        $total_scnt = 0;
        $total_qnty = 0;
        $total_sale = 0;
        foreach ($dataSetA as $key => $data) {
          // 데이터 선언
          $scnt = $data['scnt'];
          $qnty = $data['qnty'];
          $sale = $data['sale'];

          // 데이터 가공
          $sale = number_format($sale).'원';

          $total_scnt += $data['scnt'];
          $total_qnty += $data['qnty'];
          $total_sale += $data['sale'];

          // 데이터 출력
          echo "
            <tr>
              <td>$key</td>
              <td class='right'>$scnt</td>
              <td class='right'>$qnty</td>
              <td class='right'>$sale</td>
            </tr>
          ";
        }

        $total_sale = number_format($total_sale).'원';

        echo "
          <tr class='yellow'>
            <td>합계</td>
            <td class='right'>$total_scnt</td>
            <td class='right'>$total_qnty</td>
            <td class='right'>$total_sale</td>
          </tr>
        ";

      ?>
    </table>
    </div>
  
  <? } elseif ($action == 'selectB') { ?>

    <div id="tableWrap">
    <table width="100%" cellpading="3" cellspacing="1">
      <?php 
        $total_subj = [];
        // 헤더
        echo "<tr class='header'>";
        echo "<th>월</th>";
        foreach ($subjList as $subj) {
          $total_subj[$subj] = 0;
          echo "<th>$subj</th>";
        }
        echo "<th>합계</th>";

        foreach ($dataSetB as $key => $data) {
          $total_sale = 0;
          echo "<tr>";
          echo "<td>$key"."월</td>";
          foreach ($subjList as $subj) {
            $total_sale += $data[$subj];
            $total_subj[$subj] += $data[$subj]; 
            $sale = number_format($data[$subj]).'원';
            echo "<td class='right'>$sale</td>";
          }
          $total_sale = number_format($total_sale).'원';
          echo "<td>$total_sale</td>";
          echo "</tr>";
        }
        // console_log($total_subj);

        echo "<tr class='yellow'>";
        echo "<td>합계</td>";
        $total_all = 0;
        foreach ($subjList as $subj) {
          $total_all += $total_subj[$subj];
          $total_sale = $total_subj[$subj];
          $total_sale = number_format($total_sale).'원';
          echo "<td>$total_sale</td>";
        }
        $total_all = number_format($total_all).'원';
        echo "<td>$total_all</td>";
        echo "</tr>";

      ?>
    </table>
    </div>

    <div class="tbMenu">
      <table class="inner" width="100%">
        <tr>
          <td class="left"></td>
          <td class="right" style="vertical-align:bottom;">
            <input type="button" value="뒤로" 
            onclick="location.href='view.php<?=$linkUrlParam?>'">
          </td>
        </tr>
      </table>
    </div>

  <? } ?>

</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>