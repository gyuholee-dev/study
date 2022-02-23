<?php
require_once 'init.php';

// 변수
$table = 'membership';
$tableName = '체육센터';
$title = "<i class='xi-list-dot'></i> $tableName"." 종목별 현황";
$fileName = 'detail.php';

// 파라메터 처리
$action = 'select';
$page = 1;
$stud = 'all';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['stud'])) {
  $stud = $_REQUEST['stud'];
}

// 카테고리
$stat = 'all';
$whereSql = '';
if (isset($_REQUEST['stat'])) {
  $stat = $_REQUEST['stat'];
}

// url 기본 파라메터
$urlParam = "&page=$page&stud=$stud";
$linkUrlParam = "?action=$action$urlParam";

// WHERE 처리
if ($stat !== 'all') {
  $whereSql .= "WHERE stat = '$stat' "; 
}

// 납부상태 리스트
$statList = array();
$sql = "SELECT DISTINCT(stat) AS stat
        from $table ORDER BY stat ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($statList, $a['stat']);
}

// 종목 리스트
$studList = array();
$sql = "SELECT
        DISTINCT(stud) AS stud, dues
        FROM $table ORDER BY stud ASC ";

$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $studList[$a['stud']] = $a['dues'];
}

// 데이터셋
$dataSet = array();
foreach ($studList as $key => $value) {
  $dataSet[$key] = [
    'dues' => $value,
    'mcnt' => 0,
    'total' => 0
  ];
}
$sql = "SELECT stud, dues,
        COUNT(*) AS mcnt,
        (dues * COUNT(*)) AS total
        FROM membership
        $whereSql
        GROUP BY stud ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $dataSet[$a['stud']] = [
    'dues' => $a['dues'],
    'mcnt' => $a['mcnt'],
    'total' => $a['total']
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
            <input type="hidden" name="stud" value="<?=$stud?>">
            <?php
              echo "<label for='cont'><b>납부상태</b> ";
              echo "<select name='stat' onchange='changeView()'>";
              echo "<option value='all'>전체</option>";
              foreach ($statList as $key => $value) {
                $selected = ($stat == $value)?'selected':'';
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
        <th>종목</th>
        <th>이용료</th>
        <th>회원수</th>
        <th>합계</th>
      ";

      $total_dues = 0;
      $total_mcnt = 0;
      $total_all = 0;
      foreach ($dataSet as $key => $data) {
        // 데이터 선언
        $dues = $data['dues'];
        $mcnt = $data['mcnt'];
        $total = $data['total'];

        // 데이터 가공
        $dues = number_format($dues).'원';
        $total = number_format($total).'원';

        $total_dues += $data['dues'];
        $total_mcnt += $data['mcnt'];
        $total_all += $data['total'];

        // 데이터 출력
        echo "
          <tr>
            <td>$key</td>
            <td class='right'>$dues</td>
            <td class='right'>$mcnt</td>
            <td class='right'>$total</td>
          </tr>
        ";
      }

      $total_dues = number_format($total_dues).'원';
      $total_all = number_format($total_all).'원';

      echo "
        <tr class='yellow'>
          <td>합계</td>
          <td class='right'>$total_dues</td>
            <td class='right'>$total_mcnt</td>
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