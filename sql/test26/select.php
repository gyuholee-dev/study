<?php
require_once 'includes/init.php';

$action = 'select';
$title = $tableName.' 조회';

include 'includes/_tbstart.php';
?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- tbcontents -->
<?php
    include 'includes/_tbcontents.php';
?>
<!-- tbcontents -->
<hr>
<?php
    include 'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>