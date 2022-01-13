<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$tableName = '';
if (isset($_POST['read']) && $_POST['tableName']) {
    $tableName = $_POST['tableName'];
    // echo '$tableName: '.$tableName;
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>텍스트 파일 읽고 쓰기</h3>
<hr>
<br>

<form method="post" action="test13.php" autocomplete="off">
테이블명:
<input type="text" name="tableName" value="<?=$tableName?>" autofocus>
<input type="submit" name="read" value="실행">
</form>

<br>

<div class="result">
<?php
    if (isset($_POST['read']) && $_POST['tableName']) {
        // $tableName = $_POST['tableName'];
        
        $sql = "DESC $tableName";
        $res = mysqli_query($db, $sql);
        $cnt = mysqli_num_rows($res);
        // echo "$tableName 의 항목 갯수: $cnt";

        $sql = "SELECT * FROM $tableName";
        $res = mysqli_query($db, $sql);
        $cnt2 = mysqli_num_rows($res);

        $textDir = 'text/';
        $fileName = $tableName.'.txt';
        $targetFile = fopen($textDir.$fileName, 'w');

        echo 'FILE: '.$textDir.$fileName.'<br>';

        // 쓰기
        $num = 1;
        while ($a = mysqli_fetch_row($res)) {
            $fileContents = ''; 
            // echo "$a[0], $a[1], $a[2], $a[3], $a[4]<br>";
            for ($i=0; $i<$cnt; $i++) {
                // echo $a[$i];
                $fileContents = $fileContents.$a[$i];
                if ($i != $cnt-1) {
                    // echo '^';
                    $fileContents = $fileContents.'^';
                }
            }
            if ($cnt2 != $num) {
                $fileContents = $fileContents."\n";
            }
            $num++;
            if (fwrite($targetFile, $fileContents) != 0) {
                // echo ' : WRITE OK<br>';
            } else {
                // echo ' : ERROR<br>';
            }
        }
        fclose($targetFile);

        // 읽기
        $resultFile = fopen($textDir.$fileName, 'r');
        while (!feof($resultFile)) {
            $str = fgets($resultFile, 1000);
            echo $str.'<br>';
        }
    }
?>
</div>


</body>
</html>