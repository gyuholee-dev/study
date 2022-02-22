<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'membership';
$tableName = '체육센터';
$title = "<i class='xi-list-dot'></i> $tableName 회원현황";
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
$stud = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['stud'])) {
  $stud = $_REQUEST['stud'];
}

// url 기본 파라메터
$urlParam = "&stud=$stud";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($stud != 'all') $whereSql .= "AND stud = '$stud' " ;

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// 종목 리스트
$studList = array();
$sql = "SELECT DISTINCT(stud) AS stud
        from $table ORDER BY stud ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($studList, $a['stud']);
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
            echo "<label for='cont'><b>종목</b> ";
            echo "<select name='stud' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($studList as $key => $value) {
              $selected = ($stud == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label> ";
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
        <th>ID</th>
        <th>이름</th>
        <th>종목</th>
        <th>이용료</th>
        <th>납부</th>
        <th>담당</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $numb = $data['numb'];
        $memb = $data['memb'];
        $name = $data['name'];
        $stud = $data['stud'];
        $dues = $data['dues'];
        $stat = $data['stat'];
        $inst = $data['inst'];

        // 데이터 가공
        $dues = number_format($dues).'원';
        $stat = "<a href='detail.php?stat=$stat".
                "&action=$action.$linkUrlParam'>$stat</a>";

        // 데이터 출력
        echo "
          <tr>
            <td>$numb</td>
            <td>$memb</td>
            <td>$name</td>
            <td>$stud</td>
            <td class='right'>$dues</td>
            <td>$stat</td>
            <td>$inst</td>
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
