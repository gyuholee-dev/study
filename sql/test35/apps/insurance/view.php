<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'insurance';
$tableName = '보험가입';
$title = "<i class='xi-list-dot'></i> $tableName 현황";
$fileName = 'view.php';

// 페이지 변수
$items = 9;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// 카테고리 변수
$cont = 'all';
$area = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['cont'])) {
  $cont = $_REQUEST['cont'];
}
if (isset($_REQUEST['area'])) {
  $area = $_REQUEST['area'];
}

// url 기본 파라메터
$urlParam = "&cont=$cont&area=$area";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($cont != 'all') $whereSql .= "AND cont = '$cont' " ;
if ($area != 'all') $whereSql .= "AND area = '$area' " ;

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// 보험 리스트
$contList = array();
$sql = "SELECT DISTINCT(cont) AS cont
        from $table ORDER BY cont ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($contList, $a['cont']);
}

// 지역 리스트
$areaList = array();
$sql = "SELECT DISTINCT(area) AS area
        from $table ORDER BY area ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($areaList, $a['area']);
}

// SELECT 처리
$sql = "SELECT * from $table ";
$sql .= $whereSql;
$sql .= "ORDER BY 1 DESC ";
$sql .= "LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

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
          <?php
            echo "<label for='cont'><b>보험</b> ";
            echo "<select name='cont' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($contList as $key => $value) {
              $selected = ($cont == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label> ";
            echo "<span style='margin-right:10px;'></span>";
            echo "<label for='area'><b>지점</b> ";
            echo "<select name='area' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($areaList as $key => $value) {
              $selected = ($area == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label>";
          ?>
          </form>
        </td>
        <td class="right">
          <input type="button" value="초기화" 
          onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
          <input type="button" value="메뉴" 
          onclick="location.href='index.php'">
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
        <th>번호</th>
        <th>성명</th>
        <th>주민등록번호</th>
        <th>성별</th>
        <th>가입일</th>
        <th>보험구분</th>
        <th>납입료</th>
        <th>가입지점</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $numb = $data['numb'];
        $name = $data['name'];
        $rnum = $data['rnum'];
        $gend = $data['gend'];
        $sinc = $data['sinc'];
        $cont = $data['cont'];
        $prem = $data['prem'];
        $area = $data['area'];

        // 데이터 가공
        $sinc = date('Y년 m월 d일', strtotime($sinc));
        $prem = number_format($prem).'원';
        $gend = ($gend=='M')?'남':'여';
        $gend = "<a href='detail.php?gend=$data[gend]".
                "&action=$action.$linkUrlParam'>$gend</a>";

        // 데이터 출력
        echo "
          <tr>
            <td>$numb</td>
            <td>$name</td>
            <td>$rnum</td>
            <td>$gend</td>
            <td>$sinc</td>
            <td>$cont</td>
            <td class='right'>$prem</td>
            <td>$area</td>
          </tr>
        ";
      }

    ?>
  </table>
  </div>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="72">
      <?php
        if ($action == 'select') {
          echo "
            <input type='button' value='생성' 
            onclick='location.href=\"create.php\"'>
          ";
        } elseif ($action == 'manage') {
          $url = "view.php?action=select$linkUrlParam";
          echo "
            <input type='button' value='조회' 
            onclick='location.href=\"$url\"'>
          ";
        }
      ?>
      </td>
      <td>
      <?php
        if ($pageCount != 1) {
          $listMin = 1;
          $listMax = 9;
          $pageUrlParam = "&action=$action$urlParam";

          echo "<span class='page'>";
          if ($page == 1) {
            echo "<<";
          } else {
            echo "<a href='$fileName?page=1$pageUrlParam'><<</a>";
          }
          echo "</span>";
          
          if ($rows > 0) {
            if ($pageCount > 9) {
              if ($page > $pageCount-8) {
                if ($page - 4 < 1) {
                  $listMin = 1;
                  $listMax = 9;
                } elseif ($page > $pageCount-5) {
                  $listMin = $pageCount-8;
                  $listMax = $pageCount;
                } else {
                  $listMin = $page-4;
                  $listMax = $page+4;
                }
              } elseif ($page > 5) {
                $listMin = $page-4;
                $listMax = $page+4;
              }
            }
            for ($i=1; $i<=$pageCount; $i++) {
              if ($i < $listMin || $i > $listMax) {
                continue;
              }
              echo "<span class='page'>";
              if ($i == $page) {
                echo "<b>$i</b>";
              } else {
                echo "[<a href='$fileName?page=$i$pageUrlParam'>$i</a>]";
              }
              echo '</span>';
            }
          } else {
            echo "<span class='page'>";
            echo "<b>1</b>";
            echo '</span>';
          }

          echo "<span class='page'>";
          if ($page == $pageCount) {
            echo ">>";
          } else {
            echo "<a href='$fileName?page=$pageCount$pageUrlParam'>>></a>";
          }
          echo '</span>';
        }

      ?>
      </td>
      <td class="right" width="72">
      <?php
        if ($action == 'select') {
          // $url = "view.php?action=manage$linkUrlParam";
          // echo "
          //   <input type='button' value='편집' 
          //   onclick='location.href=\"$url\"' disabled>
          // ";
          $url = "detail.php?action=select$linkUrlParam";
          echo "
            <input type='button' value='상세' 
            onclick='location.href=\"$url\"'>
          ";
        } elseif ($action == 'manage') {
          $url = "edit.php?action=insert$linkUrlParam";
          echo "
            <input type='button' class='active' value='등록' 
            onclick='location.href=\"$url\"'>
          ";
        }
      ?>
      </td>
      </tr>
    </table>
  </div>


</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>
