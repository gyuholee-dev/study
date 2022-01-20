<?php
require 'include/global22.php';

$title = $tableName.' 관리';

// if (tableExist($table) == false) {
//     echo "<script>location.href='$id\_create.php';</script>";
// }
?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<h3><?=$title?></h3>
<hr>

<?php
    include $id.'_menu.php';
?> 
<?php
    include $id.'_footer.php';
?>