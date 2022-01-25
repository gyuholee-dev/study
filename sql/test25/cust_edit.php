<?php
require_once 'cust_init.php';

$action = 'edit';
$title = $tableName.' 편집';

$selectSql = "SELECT * FROM cust";

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