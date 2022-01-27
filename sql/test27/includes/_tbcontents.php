<div class="tbContents">
  <?php
    if ($action != 'delete') {
      include 'includes/_tbmenu.php';
    } 
  ?>
  <table class="<?=$action?>" 
    cellpadding="3" cellspacing="0" border="1">
  <?php
    echo '<tr>';
    foreach ($nameSpace as $key => $value) {
      echo '<th>'.$value.'</th>';
    }
    if ($action == 'edit') {
      echo '<th width="50">수정</th>';
      echo '<th width="50">삭제</th>';
    }
    echo '</tr>';

    while ($a = mysqli_fetch_assoc($res)) {
      $urlParam = $primeKey.'='.$a[$primeKey];
      $urlParam = getURLParam(false, $urlParam);
      $updateUrl = 'update.php'.$urlParam;
      $deleteUrl = 'delete.php'.$urlParam;

      echo '<tr>';
      foreach ($a as $key => $value) {
        echo '<td>'.$value.'</td>';
      }

      if ($action == 'edit') {
        echo '<td><a href="'.$updateUrl.'">수정</a></td>';
        echo '<td><a href="'.$deleteUrl.'">삭제</a></td>';
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
          echo '[<a href="'.$action.'.php?items='.$items.'&page='.$i.
            '&where='.$where.'&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
        }
        echo '</span>';
      }
    }
  ?>
  </div>
</div>