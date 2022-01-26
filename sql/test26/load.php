<?php
require_once 'includes/init.php';

$action = 'load';
// $title = $tableName.' 조회';
$title = '해설자료 넣기';

$items = 5;
$page = 1;
$pages = 99;
$start = 0;
$file = '';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['file'])) {
  $numb = $_REQUEST['numb'];
  $file = $_REQUEST['file'];

  $file = str_replace(' ', '', $file);
  $file = str_replace('?', '', $file);
  $str = '';
  $ff = fopen('text/'.$file.'.txt', 'r');
  while (!feof($ff)) {
    // $str = $str.iconv('EUC-KR', 'UTF-8', fgets($ff, 1000));
    $s = fgets($ff, 1000);
    $s = trim($s).' ';
    $str = $str.$s;
  }
  fclose($ff);

  // $str = str_replace("'", "\'", $str);
  $str = addslashes($str);

  $sql = "UPDATE paint 
          SET comt = '$str'
          WHERE numb = '$numb'
          ";
  echo $sql;
  mysqli_query($db, $sql);
  $msg = $title.' 완료';
  $url = 'load.php?page='.$page;
  sendMsg($msg, $url);
}
$sql = "SELECT COUNT(*) FROM paint";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);
$start = ($page-1)*$items;

$sql = "SELECT * FROM paint
        LIMIT $start, $items
        ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>

<!-- <div class="tbContents">
  <?php
    if ($file != '') {
      $file = str_replace(' ', '', $file);
      $str = '';
      $ff = fopen('text/'.$file.'.txt', 'r');
      while (!feof($ff)) {
        // $str = $str.iconv('EUC-KR', 'UTF-8', fgets($ff, 1000));
        $s = fgets($ff, 1000);
        $s = trim($s).' ';
        $str = $str.$s;
      }
  ?>
    <img src="images/<?=$file?>.jpg" style="width:400px;">
    <textarea style="width:400px;height:200px;"
    ><?=$str?></textarea>
  <?php
    }
  ?>
</div> -->

<div class="tbContents">
  <!-- <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
        <td class="left"></td>
        <td class="right">
          <input type="button" value="메뉴"
          onclick="location.href='start.php'?>'">
        </td>
      </tr>
    </table>
  </div> -->
  <table cellpadding="3" cellspacing="0" border="1">
    <tr>
      <th><?=$nameSpace['numb']?></th>
      <th><?=$nameSpace['name']?></th>
      <th><?=$nameSpace['pntr']?></th>
      <th><?=$nameSpace['kind']?></th>
      <th width="240"><?=$nameSpace['comt']?></th>
      <th>해설넣기</th>
    </tr>
    
    <?php
      while ($a = mysqli_fetch_assoc($res)) {

        $textUrl = 'load.php?file='.$a['name'].
                   '&numb='.$a['numb'].
                   '&page='.$page;
        echo '<tr>';
        echo '<td>'.$a['numb'].'</td>';
        echo '<td>'.$a['name'].'</td>';
        echo '<td>'.$a['pntr'].'</td>';
        echo '<td>'.$a['kind'].'</td>';
        echo '<td><textarea>'.$a['comt'].'</textarea></td>';
        echo '<td>';
        // echo '<a href="'.$textUrl.'">보기</a>';
        echo '<a href="'.$textUrl.'">Load</a>';
        echo '</td>';
        echo '</tr>';
      }
    ?>

  </table>

  <div class="tbMenu">
  <?php
    for ($i=1; $i<=$pages; $i++) {
      echo '<span class="page">';
      if ($i == $page) {
        echo "<b>$i</b>";
      } else {
        echo '[<a href="'.$action.'.php'.
              '?page='.$i.'">'.$i.'</a>]';
      }
      echo '</span>';
    }
  ?>
  </div>
</div>

<hr>
<?php
    include 'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>