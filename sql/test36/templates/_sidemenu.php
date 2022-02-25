<?php
$sql = "SELECT 
        couscode,
        cousname 
        FROM cousmast ";
$res = mysqli_query($db, $sql);

while ($a = mysqli_fetch_row($res)) {
  $url = "start.php?couscode=$a[0]";
  $active = '';
  if ($couscode = $a[0]) {
    $active = 'active';
  }
  echo "<a class='item' href='$url'>$a[1]</a>";
}
