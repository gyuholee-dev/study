<?php
require 'include/global.php';

$backup = false;
$restore = false;
$clear = false;
$sep = '*';
$file = 'text/ordr.txt';

if (isset($_POST['backup'])) {
    if (isset($_POST['sep'])) {
        $sep = $_POST['sep'];
    }
    $file = $_POST['file'];
    if (file_exists($file)) {
        $backup = true;
    }
} elseif (isset($_POST['restore'])) {
    if (isset($_POST['clear'])) {
        $clear = $_POST['clear'];
    }
    if (isset($_POST['sep'])) {
        $sep = $_POST['sep'];
    }
    $file = $_POST['file'];
    if (file_exists($file)) {
        $restore = true;
    }
}

?>
<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 백업</h3>
<hr>
<br>

<form method="post" action="test16_backup.php">
    <label for="file">파일 입력</label>
    <input type="text" name="file" id="file" required
    value="<?=$file?>">
    <label for="sep" style="margin-left:10px;">구분자</label>
    <input type="text" name="sep" id="sep" value="<?=$sep?>"
    style="width:20px;">
    <label style="margin-left:20px; margin-right:10px;">
        <input type="checkbox" name="clear" <?if($clear)echo'checked';?>>테이블 클리어
    </label>
    <input type="submit" name="backup" value="백업">
    <input type="submit" name="restore" value="리스토어">
</form>

<br>

<?php
    if ($backup == true) {
        echo '<div class="result">';
        $sql = "SELECT * FROM ordr";
        $res = mysqli_query($db, $sql);
        $rowCount = mysqli_num_rows($res);

        $ff = fopen($file, 'w');
        $path = str_replace(basename(__FILE__), '', realpath(__FILE__));
        $path = str_replace('\\','/', $path);
        echo 'FILE: '.$path.$file.'<br>';

        $num = 1;
        while ($a = mysqli_fetch_row($res)) {
            $str = '';
            $c = count($a);
            for ($i=0; $i < $c; $i++) {
                $str = $str.$a[$i];
                if ($i != $c-1) {
                    $str = $str.$sep;
                }
            }
            if ($num != $rowCount) {
                $str = $str."\n";
                $num++;
            }
            fwrite($ff, $str);
            echo $str.' : WRITE OK<br>';
        }
        fclose($ff);
        echo '</div>';

    } elseif ($restore == true) {
        echo '<div class="result">';
        if ($clear == true) {
            $sql = "DELETE FROM ordr";
            echo $sql.' : Query OK<br>';
            mysqli_query($db, $sql);
        }
        $sql = "DESC ordr";
        $res = mysqli_query($db, $sql);
        $a = mysqli_fetch_row($res);
        $rowCount = mysqli_num_rows($res);
        // echo '$rowCount: '.$rowCount.'<br>';

        $ff = fopen($file, 'r');
        while (!feof($ff)) {
            $str = fgets($ff, 1000);
            if (mb_strlen(trim($str)) != 0) {
                $data = explode($sep, $str);

                if (count($data) >= $rowCount) {
                    $data = array_splice($data, 0, $rowCount);

                    $dataStr = trim(implode("', '", $data));
                    $dataStr = "'".$dataStr."'";
                    $sql = "INSERT INTO ordr
                            VALUES ($dataStr)";
                    mysqli_query($db, $sql);
        
                    echo $sql;
                    echo ' : READ OK<br>';
                } else {
                    echo $str.' : ERROR<br>';
                }
            }
        }
        fclose($ff);
        echo '</div>';
    }
?>

<br> 
<hr><br>
<?php
    include 'test16_menu.html';
?>
<?php
    include 'test16_footer.html';
?>