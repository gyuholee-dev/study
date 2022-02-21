<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'custlist';
$tableName = '한국유통';
$title = "$tableName 고객관리";
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
$search = '';
$whereSql = '';
if (isset($_REQUEST['search'])) {
  $search = $_REQUEST['search'];
}

// url 기본 파라메터
$urlParam = "&search=$search";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($search !== '') {
  $search = htmlspecialchars($search);
  $whereSql = "
    WHERE 
    code LIKE '%$search%' OR 
    comp LIKE '%$search%' OR 
    pers LIKE '%$search%' OR 
    posn LIKE '%$search%' OR 
    addr LIKE '%$search%' OR 
    cont LIKE '%$search%' 
  "; 
}

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

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
  <style>
    span.emp {
      background-color: #ffff80;
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
          <form id="tbmenu" method="get" autocomplete="off">
            <input type="hidden" name="action" value="<?=$action?>">
            <input type="text" name="search" value="<?=$search?>" autofocus>
            <input type="submit" value="검색">
            <input type="button" value="초기화" 
            onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
          </form>
        </td>
        <td class="right">
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
        <th>코드</th>
        <th>회사명</th>
        <th>담당자</th>
        <th>직위</th>
        <th>주소</th>
        <th>연락처</th>
      ";

      if ($rows > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
          
          // 데이터 가공
          foreach ($data as $key => $value) {
            $data[$key] = str_replace("$search", 
              "<span class='emp'>$search</span>", $value);
          }

          // 데이터 선언
          $code = $data['code'];
          $comp = $data['comp'];
          $pers = $data['pers'];
          $posn = $data['posn'];
          $addr = $data['addr'];
          $cont = $data['cont'];

          // 데이터 출력
          echo "
            <tr>
              <td>$code</td>
              <td class='left'>$comp</td>
              <td>$pers</td>
              <td>$posn</td>
              <td class='left'>$addr</td>
              <td>$cont</td>
            </tr>
          ";
        }

      } else {
        echo "
          <tr>
            <td colspan='6' style='width:600px'>레코드가 없습니다</td>
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
          $url = "view.php?action=manage$linkUrlParam";
          echo "
            <input type='button' value='편집' 
            onclick='location.href=\"$url\"' disabled>
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
