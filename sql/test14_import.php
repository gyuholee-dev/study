<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

if (isset($_FILES)) {
    $file = $_FILES['file'];
    print_r($file);
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 적재</h3>
<hr>
<br>

<form method="post" action="test14_import.php" enctype='multipart/form-data'>
    <input type="file" name="file">
    <input type="submit" name="upload" value="실행">
</form>

<br>

<div class="result">
<?php
    // if (isset($_POST['read']) && $_POST['fileName']) {

    // }
?>
</div>


</body>
</html>