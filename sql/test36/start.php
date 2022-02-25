<?php
require_once 'includes/init.php';

$fileName = 'start.php';
$content = '';

if ($action == 'view') {
  $title = "$tableName 관리";
  $content = 'includes/_view.php';

} elseif ($action == 'edit') {
  $title = "$tableName 편집";
  $content = 'includes/_edit.php';

} elseif ($action == 'create') {
  $title = "$tableName 생성";
  $content = 'includes/_create.php';
}

include 'templates/template.php';

?>
