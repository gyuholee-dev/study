<?php
require_once 'init.php';

// 변수
$table = 'insurance';
$tableName = '보험가입';
$title = "<i class='xi-list-dot'></i> $tableName 별 판매실적";
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
$whereSql = 'WHERE 1 = 1 ';
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

// area 리스트
$areaList = array();

// SELECT 처리
// $sql = "SELECT 
//         DISTINCT(cont)
//         FROM $table ";
// $sql .= $whereSql;
// $sql .= "GROUP BY cont ";
// $sql .= "ORDER BY cont ASC, area ASC ";

$sql = "SELECT 
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
        GROUP BY cont";
// $sql = "SELECT *, 
//         (seoul+chungcheong+gangwon+yeongnam+honam) AS total_prem
//         FROM ($sql) ";

echo $sql;
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
            <input type="hidden" name="cont" value="<?=$cont?>">
            <input type="hidden" name="area" value="<?=$area?>">
            <?php
              $checked = ['all'=>'', 'M'=>'', 'F'=>''];
              $checked[$gend] = 'checked';
            ?>
            <b>성별:</b>
            <label><input onchange="changeView()" <?=$checked['all']?>
              type="radio" name="order" value="all">전체</label>
            <label><input onchange="changeView()" <?=$checked['M']?>
              type="radio" name="order" value="M">남성</label>
            <label><input onchange="changeView()" <?=$checked['F']?>
              type="radio" name="order" value="F">여성</label>
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
        <th>보험구분</th>
        <th>서울</th>
        <th>충청</th>
        <th>강원</th>
        <th>영남</th>
        <th>호남</th>
        <th>합계</th>
      ";
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