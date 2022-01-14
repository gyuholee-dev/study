<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$import = false;
$drop = false;
$sep = '^';
$file = 'text/asst.txt';

if (isset($_POST['import'])) {
    if (isset($_POST['drop'])) {
        $drop = $_POST['drop'];
    }
    if (isset($_POST['sep'])) {
        $sep = $_POST['sep'];
    }
    $file = $_POST['file'];
    if (file_exists($file)) {
        $import = true;
    }
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 적재</h3>
<hr>
<br>

<form method="post" action="test14_import.php">
    <label for="file">파일 입력</label>
    <input type="text" name="file" id="file" required
    value="<?=$file?>">
    <label for="sep" style="margin-left:10px;">구분자</label>
    <input type="text" name="sep" id="sep" value="<?=$sep?>"
    style="width:20px;">
    <label style="margin-left:20px; margin-right:20px;">
        <input type="checkbox" name="drop" <?if($drop)echo'checked';?>>테이블 드랍
    </label>
    <input type="submit" name="import" value="적재">
</form>

<br>

<?php
    if ($import == true) {
        echo '<div class="result">';
        if ($drop == true) {
            $sql = "DROP TABLE IF EXISTS asst";
            echo $sql.' : OK<br>';
            // mysqli_query($db, $sql);
        }
        /* 
        $sql = "LOAD DATA INFILE $file
                INTO TABLE asst
                FIELDS TERMINATED BY $sep";
        mysqli_query($db, $sql);
         */
        $sql = "DESC asst";
        $res = mysqli_query($db, $sql);
        $a = mysqli_fetch_row($res);
        $rowCount = mysqli_num_rows($res);
        echo '$rowCount: '.$rowCount.'<br>';

        $ff = fopen($file, 'r');
        while (!feof($ff)) {
            $str = fgets($ff, 1000);
            $data = explode($sep, $str);

            if (count($data) >= $rowCount) {
                $data = array_splice($data, 0, $rowCount);

                $dataStr = trim(implode("', '", $data));
                $dataStr = "'".$dataStr."'";
                $sql = "INSERT INTO asst
                        VALUES ($dataStr)";
                // mysqli_query($db, $sql);
    
                echo $sql;
                echo ' : OK<br>';
            } else {
                echo $str.' : ERROR<br>';
            }

        }
        echo '</div>';
    }
?>

<br> 
<hr><br>
<?php
    include 'test14_menu.html';
?>
</body>
</html>