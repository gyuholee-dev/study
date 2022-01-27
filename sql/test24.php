<?php
include 'include/global22.php';

/* 
$sql = "CREATE TABLE test 
        (
            key1 char(5) not null, 
            name char(10), 
            addr char(99), 
            primary key(key1)
        )";
mysqli_query($db, $sql);
 */

function getTime() { 
    $t = explode(' ',microtime()); 
    return (float)$t[0]+(float)$t[1]; 
}


$which = '';
$times = '';

if (isset($_POST['act'])) {
    $which = $_POST['which'];
    $times = $_POST['times'];

    if ($which == 1) {
        $sql = "DELETE FROM test";
        mysqli_query($db, $sql);

        // $start = date('H:i:s');
        $start = getTime();
        for ($i=1; $i <= $times; $i++) { 
            $no = '00000'.(string)$i;
            $no = substr($no, -5);
            // $no = substr('00000'.$i, strlen($i), 5);
            // echo $no.'<br>';
            $sql = "INSERT into TEST
                    VALUES('$no', '도영해', '부산시 해운대구 좌4동')";
            mysqli_query($db, $sql);
        }
        // $finish = date('H:i:s');
        $finish = getTime();
    }
    if ($which == 2) {
        // $start = date('H:i:s');
        $start = getTime();
        $file = fopen('text/test24.txt', 'w');
        for ($i=0; $i <= $times; $i++) { 
            $str = "$i 도영해 부산시 해운대구 좌4동\n";
            fwrite($file, $str);
        }
        fclose($file);
        // $finish = date('H:i:s');
        $finish = getTime();
    }

    $resTime = $finish - $start;
    $resTime = number_format($resTime, 6);
    echo "수행시간 = $resTime<br>";
}

?>
<?php
include 'test22_header.php';
?>
<center>
<h3>DB Table 과 Text File 속도 비교</h3>
<hr>
<br>
<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test24.php">
    <tr>
        <th width="80">선택</th>
        <td class="left">
            <input size="1" type="text" name="which" value="<?=$which?>">
            (1:테이블 2:텍스트)
        </td>
    </tr>
    <tr>
        <th>횟수</th>
        <td class="left">
            <input size="4" type="text" name="times" value="<?=$times?>">
            회
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" name="act" value="실행">
        </td>
    </tr>
</form>
</table>

</html>
<?php
include 'test22_footer.php';
?>