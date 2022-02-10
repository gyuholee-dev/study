<?php
require_once 'includes/init.php';

$action = 'view';
$title = '개설과정 현황';
$fileName = 'view_subject.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'edit') {
  $title = '개설과정 수정';
}

$items = 99;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

$subjcode = 'all';
$whereSql = '';
if (isset($_REQUEST['subjcode'])) {
  $subjcode = $_REQUEST['subjcode'];
  if ($subjcode != 'all') {
    $whereSql = "WHERE subjcode = '$subjcode' ";
  }
}

$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM subject ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$subjectList = array();
$sql = "SELECT subjcode, subjname FROM subject ORDER BY subjname ASC";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $subjectList[$a['subjcode']] = $a['subjname'];
}

// $sql = "SELECT * FROM subject ";
$sql = "SELECT 
        subject.*,
        (
          SELECT COUNT(*) 
          FROM student
          WHERE subjcode = subject.subjcode
        ) AS stud_cnt 
        FROM subject ";
$sql = $sql.$whereSql;
$sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);


?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<div class="tbContents">

  <script>
    function changeView() {
      var form = document.getElementById('tbmenu');
      form.submit();
    }
  </script>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
        <?php
          if($action == 'detail') {
            echo '<form method="get" action="" id="tbmenu">';
            echo '<input type="hidden" name="action" value="'.$action.'">';
            echo '<label for="subject">과목</label>';
            echo '<select name="subject" id="subject" onchange="changeView()">';
            echo '<option value="all">전체</option>';
              foreach ($subjectList as $key => $value) {
                $selected = '';
                if ($subjcode == $key) {
                  $selected = ' selected';
                }
                echo '<option value="'.$key.'"'.
                $selected.'>'.$value.'</option>';
              }
            echo '</select>';
            echo '</form>';
          } 
        ?>
      </td>
      <td class="right">
        <!-- <input type="button" value="초기화"
        onclick="location.href='<?=$fileName?>'"> -->
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>코드</th>
      <th>과정명</th>
      <th>개강일자</th>
      <th>모집정원</th>
      <th>교사명</th>
      <th>수강료</th>
      <th>학생수</th>
      <?php
        if ($action == 'view') {
          echo '<th>학생</th>';
          echo '<th>시험</th>';
        } elseif ($action == 'edit') {
          echo '<th>수정</th>';
          echo '<th>삭제</th>';
        }

      ?>
    </tr>

    <?php
      while ($a = mysqli_fetch_assoc($res)){
        $noperson = $a['noperson'].'명';
        $stud_cnt = $a['stud_cnt'].'명';
        $amtprice = number_format($a['amtprice']).'원';

        // $sql = "SELECT COUNT(*) FROM ";
        echo '<tr>';
        echo '<td>'.$a['subjcode'].'</td>';
        echo '<td>'.$a['subjname'].'</td>';
        // echo '<td>'.$a['subjkind'].'</td>';
        echo '<td>'.$a['opendate'].'</td>';
        echo '<td class="right">'.$noperson.'</td>';
        echo '<td>'.$a['teacname'].'</td>';
        echo '<td class="right">'.$amtprice.'</td>';
        // echo '<td>'.$a['usestate'].'</td>';
        echo '<td class="right">'.$stud_cnt.'</td>';
        if ($action == 'view') {
          $showStudUrl = 'view_student.php?subjcode='.$a['subjcode'];
          $showExamUrl = 'view_examines.php?subjcode='.$a['subjcode'];
          echo '<td>'.'<a href="'.$showStudUrl.'">보기</a>'.'</td>';
          echo '<td>'.'<a href="'.$showExamUrl.'">보기</a>'.'</td>';
        } elseif ($action == 'edit') {
          $updateUrl = 'edit_subject.php?action=update&subjcode='.$a['subjcode'];
          $deleteUrl = 'edit_subject.php?action=delete&subjcode='.$a['subjcode'];
          if ($a['usestate'] == 'Y') {
            echo '<td>'.'<a href="'.$updateUrl.'">수정</a>'.'</td>';
            echo '<td>'.'<a href="'.$deleteUrl.'">삭제</a>'.'</td>';
          } else {
            echo '<td>-</td>';
            echo '<td>-</td>';
          }
        }
        echo '</tr>';
      }
    
    ?>
  </table>

  <div class="tbMenu">
    <?php
      if ($pageCount != 1) {
        $listMin = 1;
        $listMax = 9;
        $pageUrlParam = '&subjcode='.$subjcode;

        echo '<span class="page">';
        if ($page == 1) {
          echo '<<';
        } else {
          echo '<a href="'.$fileName.'?page=1'.$pageUrlParam.'"><<</a>';
        }
        echo '</span>';
        
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
            echo '<span class="page">';
            if ($i == $page) {
              echo "<b>$i</b>";
            } else {
              echo '[<a href="'.$fileName.'?page='.$i.$pageUrlParam.'">'.$i.'</a>]';
            }
            echo '</span>';
          }
        } else {
          echo '<span class="page">';
          echo "<b>1</b>";
          echo '</span>';
        }

        echo '<span class="page">';
        if ($page == $pageCount) {
          echo '>>';
        } else {
          echo '<a href="'.$fileName.'?page='.$pageCount.$pageUrlParam.'">>></a>';
        }
        echo '</span>';
      }

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>