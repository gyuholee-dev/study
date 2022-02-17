<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'dailyreport';
$tableName = '일일업무일지';
$title = "$tableName 조회";
$fileName = 'view.php';

// action 처리
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = "$tableName 관리";
}

// 페이지 변수
$items = 9;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// 카테고리 변수
$date = 'all';
$name = 'all';
$whereSql = '';
if (isset($_REQUEST['date'])) {
  $date = $_REQUEST['date'];
}
if (isset($_REQUEST['name'])) {
  $name = $_REQUEST['name'];
}

// url 기본 파라메터
$urlParam = "&date=$date&name=$name";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($date !== 'all') {
  $whereSql = "WHERE yymd = '$date' "; 
}
if ($name !== 'all') {
  if ($date !== 'all') {
    $whereSql .= "AND empl = '$name' ";
  } else {
    $whereSql = "WHERE empl = '$name' ";
  }
}

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// 일자 리스트
$dateList = array();
$sql = "SELECT DISTINCT(yymd) AS date
        from dailyreport ORDER BY date ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($dateList, $a['date']);
}

// 이름 리스트
$nameList = array();
$sql = "SELECT DISTINCT(empl) AS name
        from dailyreport ORDER BY name ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($nameList, $a['name']);
}

// SELECT 처리
$sql = "SELECT * from dailyreport ";
$sql .= $whereSql;
$sql .= "ORDER BY seqn DESC ";
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
  <style>
    span.cont { width:128px; }
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
          <?php
            echo "<label for='date'><b>일자</b> ";
            echo "<select name='date' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($dateList as $key => $value) {
              $selected = ($date == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label> ";
            echo "<span style='margin-right:10px;'></span>";
            echo "<label for='date'><b>성명</b> ";
            echo "<select name='name' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($nameList as $key => $value) {
              $selected = ($name == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label>";
          ?>
          </form>
        </td>
        <td class="right">
          <input type="button" value="초기화" 
          onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
          <!-- <input type="button" value="메뉴" 
          onclick="location.href='index.php'"> -->
        </td>
      </tr>
    </table>
  </div>

  <div id="tableWrap">
  <table cellpading="3" cellspacing="1">
    <?php 
      // 헤더
      echo "<tr>";
      echo "
        <th>업무일자</th>
        <th>사원명</th>
        <th>시작시간</th>
        <th>종료시간</th>
        <th>업무구분</th>
        <th>금일업무</th>
        <th>익일업무</th>
      ";
      if ($action == 'manage') {
        echo "
          <th>수정</th>
          <th>삭제</th>
        ";
      }
      echo "</tr>";

      // 레코드
      $i = 0;
      $si = 0;
      $cnt = 0;
      $savedDate = '';
      $table = array();
      while ($a = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $seqn = $a['seqn']; 
        $yymd = $a['yymd']; 
        $empl = $a['empl']; 
        $innn = $a['innn']; 
        $outt = $a['outt']; 
        $kind = $a['kind']; 
        $todw = $a['todw']; 
        $nxdw = $a['nxdw'];

        // 데이터 가공
        $yymd = date('Y년 m월 d일', strtotime($yymd));
        $innn = date('H시 i분', strtotime($innn));
        $outt = date('H시 i분', strtotime($outt));

        // 링크
        $updateLink = 
          "edit.php?action=update&seqn=$seqn$linkUrlParam";
        $updateLink = '<a href="'.$updateLink.'">수정</a>';
        $deleteLink = 
          "edit.php?action=delete&seqn=$seqn$linkUrlParam";
        $deleteLink = '<a href="'.$deleteLink.'">삭제</a>';

        // 데이터 출력
        $str = array();

        $str[0] = "<tr>";
        if ($yymd != $savedDate) {
          $savedDate = $yymd;
          $str[1] =  "<td>";
          $str[2] = "$yymd</td>";
          $si = $i;
          $cnt = 0;
        } else {
          $table[$si][1] = '<td rowspan="'.($cnt+1).'">';
          $str[1] = '';
          $str[2] = '';
        }

        $str[2] .= "
          <td>$empl</td>
          <td>$innn</td>
          <td>$outt</td>
          <td>$kind</td>
          <td class='left'>
            <span class='cont clip'>$todw</span>
          </td>
          <td class='left'>
            <span class='cont clip'>$nxdw</span>
          </td>
        ";
        if ($action == 'manage') {
          $str[2] .= "
            <td>$updateLink</td>
            <td>$deleteLink</td>
          ";
        }
        $str[2] .= "</tr>";

        $table[$i] = $str;
        $i++;
        $cnt++;
      }

      foreach ($table as $str) {
        echo implode('', $str);
      }

    ?>

  </table>
  </div>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="150">
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
      <td class="right" width="150">
      <?php
        if ($action == 'select') {
          $url = "view.php?action=manage$linkUrlParam";
          echo "
            <input type='button' value='편집' 
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
