<?php
require_once 'init.php';

// 변수
$table = 'insurance';
$tableName = '보험가입';
$title = "<i class='xi-list-dot'></i> $tableName"."별 판매실적";
$fileName = 'detail.php';

// 파라메터 처리
$action = 'select';
$page = 1;
$cont = 'all';
$area = 'all';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['cont'])) {
  $cont = $_REQUEST['cont'];
}
if (isset($_REQUEST['area'])) {
  $area = $_REQUEST['area'];
}

// 카테고리
$gend = 'all';
$whereSql = '';
if (isset($_REQUEST['gend'])) {
  $gend = $_REQUEST['gend'];
}

// url 기본 파라메터
$urlParam = "&page=$page&cont=$cont&area=$area";
$linkUrlParam = "?action=$action$urlParam";

// WHERE 처리
if ($gend !== 'all') {
  $whereSql .= "AND gend = '$gend' "; 
}

// SELECT 처리
/* $sql = "SELECT 
        DISTINCT(cont)
        FROM $table ";
$sql .= $whereSql;
$sql .= "GROUP BY cont ";
$sql .= "ORDER BY cont ASC, area ASC "; */

/* $sql = "SELECT 
        DISTINCT(cont) AS conts,
        (
          SELECT SUM(prem) FROM insurance 
          WHERE area = '서울' AND cont = conts LIMIT 1
        ) AS seoul,
        (
          SELECT SUM(prem) FROM insurance 
          WHERE area = '충청' AND cont = conts
          LIMIT 1
        ) AS chungcheong,
        (
          SELECT SUM(prem) FROM insurance 
          WHERE area = '강원' AND cont = conts LIMIT 1
        ) AS gangwon,
        (
          SELECT SUM(prem) FROM insurance 
          WHERE area = '영남' AND cont = conts LIMIT 1
        ) AS yeongnam,
        (
          SELECT SUM(prem) FROM insurance 
          WHERE area = '호남' AND cont = conts LIMIT 1
        ) AS honam 
        FROM insurance 
        GROUP BY cont"; */

// echo $sql;
// $res = mysqli_query($db, $sql);

// 보험 리스트
$contList = array();
$sql = "SELECT DISTINCT(cont) AS cont 
        FROM insurance ORDER BY cont ASC";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($contList, $a['cont']);
}

// 지역 리스트
$areaList = array();
$sql = "SELECT DISTINCT(area) AS area 
        FROM insurance ORDER BY area ASC";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($areaList, $a['area']);
}

// 데이터셋
$dataSet = array();
foreach($contList as $key) {
  $dataSet[$key] = array();
  $sql = "SELECT area,
          SUM(prem) AS prem 
          FROM insurance 
          WHERE cont = '$key' $whereSql
          GROUP BY area ";
  $res = mysqli_query($db, $sql);
  while ($a = mysqli_fetch_assoc($res)) {
    $dataSet[$key][$a['area']] = $a['prem'];
  }
  // 데이터 검증하고 없으면 0으로 채움
  foreach ($areaList as $area) {
    if (!isset($dataSet[$key][$area])) {
      $dataSet[$key][$area] = 0;
    }
  }
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
            <input type="hidden" name="cont" value="<?=$cont?>">
            <input type="hidden" name="area" value="<?=$area?>">
            <?php
              $checked = ['all'=>'', 'M'=>'', 'F'=>''];
              $checked[$gend] = 'checked';
            ?>
            <div class="submenu">
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
        <th>보험구분</th>
        <th>서울</th>
        <th>충청</th>
        <th>강원</th>
        <th>영남</th>
        <th>호남</th>
        <th>합계</th>
      ";

      $total_seoul = 0;
      $total_chung = 0;
      $total_kangw = 0;
      $total_yungn = 0;
      $total_honam = 0;
      foreach ($dataSet as $key => $data) {
        // 데이터 선언
        $seoul = number_format($data['서울']).'원';
        $chung = number_format($data['충청']).'원';
        $kangw = number_format($data['강원']).'원';
        $yungn = number_format($data['영남']).'원';
        $honam = number_format($data['호남']).'원';
        $total = number_format($data['서울']+
                 $data['충청']+$data['강원']+
                 $data['영남']+$data['호남']).'원';

        $total_seoul += $data['서울'];
        $total_chung += $data['충청'];
        $total_kangw += $data['강원'];
        $total_yungn += $data['영남'];
        $total_honam += $data['호남'];

        // 데이터 출력
        echo "
          <tr>
            <td>$key</td>
            <td class='right'>$seoul</td>
            <td class='right'>$chung</td>
            <td class='right'>$kangw</td>
            <td class='right'>$yungn</td>
            <td class='right'>$honam</td>
            <td class='right'>$total</td>
          </tr>
        ";
      }

      $total_all = number_format($total_seoul+
                   $total_chung+$total_kangw+
                   $total_yungn+$total_honam).'원';
      $total_seoul = number_format($total_seoul).'원';
      $total_chung = number_format($total_chung).'원';
      $total_kangw = number_format($total_kangw).'원';
      $total_yungn = number_format($total_yungn).'원';
      $total_honam = number_format($total_honam).'원';

      echo "
        <tr class='yellow'>
          <td>합계</td>
          <td class='right'>$total_seoul</td>
          <td class='right'>$total_chung</td>
          <td class='right'>$total_kangw</td>
          <td class='right'>$total_yungn</td>
          <td class='right'>$total_honam</td>
          <td class='right'>$total_all</td>
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