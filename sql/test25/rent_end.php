<?php
require_once 'rent_init.php';

$action = 'edit';
// $title = $tableName.' 입력';
$title = '반납 등록';

if (isset($_REQUEST['reply'])) {
    $date = date('Y-m-d');
    $seqn = $_REQUEST['seqn'];
    $sql = "SELECT * FROM rent WHERE seqn = '$seqn'";
    $res = mysqli_query($db, $sql);
    while ($a = mysqli_fetch_assoc($res)) {
        $cust = $a['cust'];
        $toyy = $a['toyy'];

        $sql = "UPDATE rent 
                SET stat = 'B',
                    retn = '$date'
                WHERE seqn = '$seqn'";
        Mysqli_Query($db, $sql);

        $sql = "SELECT * FROM rent WHERE toyy = '$toyy'";
        $res = mysqli_query($db, $sql);

        if (mysqli_num_rows($res) == 0) {
            $sql = "UPDATE toyy 
                    SET stat = 'H'
                    WHERE numb = '$toyy'";
            Mysqli_Query($db, $sql);
        }

        $msg = "$title 완료";
        $url = "rent_end.php";
        sendMsg($msg, $url);
    }
}

$selectSql = "SELECT rent.*,
              cust.name AS cust_name,
              toyy.name AS toyy_name
              FROM rent
              JOIN cust ON rent.cust = cust.numb
              JOIN toyy ON rent.toyy = toyy.numb
              ";
$serchKey = 'rent.stat';
$where = 'R';

include 'includes/_tbstart.php';
?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<?php
    // include 'includes/_tbcontents.php';
?>
<div class="tbContents">
    <?php
        if ($action != 'delete') {
            include 'includes/_tbmenu.php';
        } 
    ?>
    <table class="<?=$action?>" 
        cellpadding="3" cellspacing="0" border="1">
    <?php
        echo '<tr>';
        echo '<th>대여일자</th>';
        echo '<th>고객명</th>';
        echo '<th>장난감명</th>';
        echo '<th>대여상태</th>';
        echo '<th>반납</th>';
        echo '</tr>';

        while ($a = mysqli_fetch_assoc($res)) {
            $urlParam = 'reply=y&'.$primeKey.'='.$a[$primeKey];
            $urlParam = getURLParam(false, $urlParam);
            $updateUrl = 'rent_end.php'.$urlParam;
            // $deleteUrl = $id.'_delete.php'.$urlParam;

            if ($a['stat'] == 'R') {
                $stat = '대여';
            } elseif ($a['stat'] == 'B') {
                $stat = '반납';
            }

            echo '<tr>';
            echo '<td>'.$a['date'].'</td>';
            echo '<td>'.$a['cust_name'].'</td>';
            echo '<td>'.$a['toyy_name'].'</td>';
            echo '<td>'.$stat.'</td>';
            // echo '<td>'.'반납'.'</td>';
            echo '<td><a href="'.$updateUrl.'">반납</a></td>';
            
            // if ($action == 'edit') {
            //     echo '<td><a href="'.$updateUrl.'">수정</a></td>';
            //     echo '<td><a href="'.$deleteUrl.'">삭제</a></td>';
            // }
            echo '</tr>';
        }
    ?>   
    </table>

    <div class="tbMenu">
    <?php
        if ($action != 'delete') {
            for ($i=1; $i<=$pages; $i++) {
                echo '<span class="page">';
                if ($i == $page) {
                    echo "<b>$i</b>";
                } else {
                    echo '[<a href="rent_end.php?items='.$items.'&page='.$i.
                        '&where='.$where.'&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
                }
                echo '</span>';
            }
        }
    ?>
    </div>
</div>
<?php
    include 'includes/_footer.php';
?>