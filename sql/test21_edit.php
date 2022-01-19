<?php
require 'include/global21.php';

$action = 'edit';
$title = $tableName.' 편집';

include $id.'_start.php';
?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<!-- tbcontents -->
<?php
    include $id.'_tbcontents.php';
?>
<!-- tbcontents -->
<hr>
<?php
    include $id.'_menu.php';
?> 
<?php
    include $id.'_footer.php';
?>