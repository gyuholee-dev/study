<?php
// 편집
// 작품번호 작품명 이미지 작가 구분 수정 삭제
require_once 'includes/init.php';

$action = 'edit';
$title = $tableName.' 편집';

$update = false;
$delete = false;

$replyUrl = 'edit.php'.
  getURLParam(false, 'reply=true');
$backUrl = 'edit.php'.
  getURLParam([$primeKey, 'update', 'delete', 'reply']);

// 수정
if (isset($_REQUEST['update'])) {
  $update = $_REQUEST['update'];
  $action = 'update';
  $title = $tableName.' 수정';
  $numb = $_REQUEST['numb'];

  $sql = "SELECT * FROM paint WHERE numb='$numb'";
  $res = mysqli_query($db, $sql);

  $preData = array();
  while ($a = mysqli_fetch_assoc($res)) {
    foreach ($a as $key => $value) {
      $preData[$key] = $value;
    }
  }

  if (isset($_POST['update'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $pntr = $_POST['pntr'];
    $kind = $_POST['kind'];
    $comt = $_POST['comt'];
    $comt = addslashes($comt);

    $sql = "UPDATE $table SET
            name = '$name',
            pntr = '$pntr',
            kind = '$kind',
            comt = '$comt'
            WHERE numb = '$numb'
            ";
    // echo $sql;
    // $sql = makeInsertSql();
    mysqli_query($db, $sql);
    $msg = $primeKey.'='.$numb." 테이블 수정 완료";
    sendMsg($msg, $backUrl);
  }
  
// 삭제
} else if (isset($_REQUEST['delete'])) {
  $delete = $_REQUEST['delete'];
  $action = 'delete';
  $title = $tableName.' 삭제';
  $numb = $_REQUEST['numb'];

  $sql = "SELECT * FROM paint WHERE numb='$numb'";
  $res = mysqli_query($db, $sql);

  if (isset($_REQUEST['reply'])) {
    $sql = "DELETE FROM $table 
            WHERE $primeKey = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = $primeKey.'='.$numb.
           ' 레코드 삭제 완료';
    sendMsg($msg, $backUrl);
  }

} else {
  include 'includes/_tbstart.php';
}
?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<?php
  if ($update == true) {
    include 'includes/_input.php';
  } else {
?>
<div class="tbContents">
  <?php
    if ($action != 'delete') {
      include 'includes/_tbmenu.php';
    } 
  ?>
  <table class="<?=$action?>" 
    cellpadding="3" cellspacing="0">
    <?php
      $nameSpace['image'] = '이미지';

      echo '<tr>';
      echo '<th>'.$nameSpace['numb'].'</th>';
      echo '<th>'.$nameSpace['name'].'</th>';
      echo '<th>'.$nameSpace['image'].'</th>';
      echo '<th>'.$nameSpace['pntr'].'</th>';
      echo '<th>'.$nameSpace['kind'].'</th>';
      echo '<th>'.$nameSpace['comt'].'</th>';
      if ($action == 'edit') {
        echo '<th>수정</th>';
        echo '<th>삭제</th>';
      }
      echo '</tr>';

      while ($a = mysqli_fetch_assoc($res)) {
        $image = $a['name'];
        $image = str_replace(' ', '', $image);
        $image = str_replace('?', '', $image);
        $imageUrl = 'images/'.$image.'.jpg';
        $imageTag = '<a href="'.$imageUrl.'">'.
                    '<img class="paint" src="'.$imageUrl.'"></a>';

        $comment = '<textarea>'.$a['comt'].'</textarea>';

        $urlParam = $primeKey.'='.$a[$primeKey];
        // $urlParam = getURLParam(false, $urlParam);
        $updateUrl = 'edit.php'.
                      getURLParam(false, 'update=true&'.$urlParam);
        $deleteUrl = 'edit.php'.
                      getURLParam(false, 'delete=true&'.$urlParam);
        $updateTag = '<a href="'.$updateUrl.'">수정</a>';
        $deleteTag = '<a href="'.$deleteUrl.'">삭제</a>';

        echo '<tr>';
        echo '<td>'.$a['numb'].'</td>';
        echo '<td>'.$a['name'].'</td>';
        echo '<td>'.$imageTag.'</td>';
        echo '<td>'.$a['pntr'].'</td>';
        echo '<td>'.$a['kind'].'</td>';
        echo '<td>'.$comment.'</td>';
        if ($action == 'edit') {
          echo '<td>'.$updateTag.'</td>';
          echo '<td>'.$deleteTag.'</td>';
        }
        echo '</tr>';
      }
    ?>
  </table>

  <div class="tbMenu">
    <?php
      if ($action != 'delete') {
        for ($i=1; $i<=$pages; $i++) {
          echo '<span class="page">';
          if ($i == $page) {
            echo "<b>$i</b>";
          } else {
            echo '[<a href="'.$action.'.php?'.
                 'items='.$items.'&page='.$i.
                 '&where='.$where.'&sort='.$sort.
                 '&order='.$order.'">'.$i.'</a>]';
          }
          echo '</span>';
        }
      }
    ?>
  </div> 
</div>
<?php
  if ($delete == true) {
    echo '<span class="red"><b>'.
         $primeKey.'='.$_REQUEST[$primeKey].
         ' 레코드를 삭제하겠습니까?'.
         '</b></span>';
    echo '<br><br>';
    echo '<input type="button" value="Yes"
          onclick="location.href=\''.$replyUrl.'\'">';
    echo ' ';
    echo '<input type="button" value="No"
          onclick="location.href=\''.$backUrl.'\'">';
  }
?>
<?php
  } // update == true
?>
<!-- contents -->
<hr>
<?php
    include 'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>