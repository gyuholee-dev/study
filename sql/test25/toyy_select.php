<?php
require_once 'toyy_init.php';

$action = 'select';
$title = $tableName.' 조회';

$selectSql = "SELECT * FROM toyy";

include 'includes/_tbstart.php';
?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<?php
    include 'includes/_tbcontents.php';
?>
<?php
    include 'includes/_footer.php';
?>