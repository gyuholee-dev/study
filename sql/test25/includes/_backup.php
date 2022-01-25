<?php 
    if ($tableExist == false || $tableReset == true) {
?>
        <span class="red"><b><?=$tableName?> 테이블을 생성하시겠습니까?</b></span>
        <br><br>
        <form method="post" action="<?=$id?>_create.php">
            <input type="submit" name="create" value="예">
            <input type="button" value="아니오" 
            onclick="location.href='<?=$id?><?if($tableReset)echo'_create'?>.php'">
        </form>

<?php
    } else {
?>
        <form method="post" action="<?=$id?>_create.php">
            <label for="file">파일 입력</label>
            <input type="text" name="file" id="file" required
            value="<?=$file?>">
            <label for="sep" style="margin-left:10px;">구분자</label>
            <input type="text" name="sep" id="sep" value="<?=$sep?>"
            style="width:20px;">
            <br><br>
            <label style="margin-right:10px;">
                <input type="checkbox" name="clear" <?if($clear)echo'checked';?>>테이블 클리어
            </label>
            <input type="submit" name="backup" value="백업">
            <input type="submit" name="restore" value="복구">
            <input type="submit" name="tableReset" value="재설정" style="margin-left:20px;">
        </form>
        <br>
<?php 
    } 
?>
<?php
    if ($backup == true) {
        echo '<div class="result">';
        $sql = "SELECT * FROM $table";
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
            $sql = "DELETE FROM $table";
            echo $sql.' : Query OK<br>';
            mysqli_query($db, $sql);
        }
        $sql = "DESC $table";
        $res = mysqli_query($db, $sql);
        $rowCount = mysqli_num_rows($res);
        $desc = mysqli_fetch_assoc($res);
        // echo '$rowCount: '.$rowCount.'<br>';

        $exceptKey = false;
        $fieldList = array();
        $i = 0;
        while ($desc = mysqli_fetch_assoc($res)) {
            if ($desc['Key'] == 'PRI' && $desc['Extra'] == 'auto_increment') {
                $exceptKey = true;
                // continue;
            }
            $fieldList[$i] = $desc['Field'];
            $i++;
        }

        $ff = fopen($file, 'r');
        while (!feof($ff)) {
            $str = fgets($ff, 1000);
            if (mb_strlen(trim($str)) != 0) {
                $data = explode($sep, $str);

                if (count($data) == $rowCount) {
                    $data = array_splice($data, 0, $rowCount);

                    $dataStr = trim(implode("', '", $data));
                    $dataStr = "'".$dataStr."'";
                    $sql = "INSERT INTO $table
                            VALUES ($dataStr)";
                    mysqli_query($db, $sql);
        
                    echo $sql;
                    echo ' : READ OK<br>';
                } elseif (count($data) >= $rowCount) {
                    if ($exceptKey == true ) {
                        array_shift($fieldList);
                    }
                    $fieldStr = implode("', '", $fieldList);

                    $data = array_splice($data, 0, $rowCount);
                    $dataStr = trim(implode("', '", $data));
                    $dataStr = "'".$dataStr."'";

                    $sql = "INSERT INTO $table($fieldStr)
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