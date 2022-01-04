<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = mysqli_connect($host, $user, $pass);
    mysqli_select_db($db, "mydb");
    mysqli_report(MYSQLI_REPORT_OFF);
?>
<!DOCTYPE html>
<html lang="ko">

<center>
<font face="맑은 고딕">
<h3>1월 4일 테스트</h3>
<hr color="blue">

<?php
/*     echo "1. 테이블 생성<br>";
    
    $sql = "DROP TABLE IF EXISTS milk";
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE milk
        (
            code CHAR(3) NOT NULL,
            name CHAR(30),
            spec CHAR(20),
            unit CHAR(2),
            prce INT,
            invt INT,
            type CHAR(10),
            PRIMARY KEY(code)
        )";
    $res = mysqli_query($db, $sql);
    if (!$res) {
        echo '테이블 생성 실패: '. mysqli_error($db);
    } else {
        echo '테이블 생성 성공';
    }
    echo "<br>";

    echo "2. 데이터 입력<br>";
    $sql = "INSERT INTO milk VALUES('111', '백색시유', '200ml', 'EA', 500, 150, '시유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('112', '백색시유', '500ml', 'EA', 900, 80, '시유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('113', '백색시유', '1000ml', 'EA', 2000, 60, '시유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('114', '초코우유', '200ml', 'EA', 600, 40, '가공유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('115', '밤맛우유', '200ml', 'EA', 700, 30, '가공유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('116', '바나나우유', '200ml', 'EA', 800, 50, '가공유')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('117', '요구르트1', '80ml', 'BX', 150, 350, '액상')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('118', '요구르트2', '120ml', 'BX', 650, 160, '호상')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO milk VALUES('119', '오렌지쥬스', '180ml', 'ST', 1200, 25, '주스')";
    mysqli_query($db, $sql); */
?>


<?php
/* // 구분이 '시유' 인 레코드만 셀렉트
// $sql = "SELECT * FROM milk WHERE type = '시유'";
// 제품종류수 및 재고량 합계
// $sql = "SELECT COUNT(*), SUM(invt) FROM milk";
// 단가가 800원 이상인 레코드
// $sql = "SELECT * FROM milk WHERE prce >= '800'";
// 품명순으로 모든 레코드
// $sql = "SELECT * FROM milk ORDER BY name ASC";
// 구분별로 그룹화하여 각 구분별 종류수 및 재고량 합계
$sql = "SELECT type, COUNT(*), SUM(invt) FROM milk GROUP BY type";
// 재고량이 많은 순서대로 상위 4개까지
$sql = "SELECT * FROM milk
        ORDER BY invt DESC
        LIMIT 0, 4";
$res = mysqli_query($db, $sql);
if (!$res) {
    echo '실패: '. mysqli_error($db);
} else {
    while ($row = mysqli_fetch_assoc($res))
    {
        // print_r($row);
        // echo "<br>";
        foreach($row as $key=>$value)
        {
            // echo $key.' ('.$value.') ';
            if ($key == 'name') {
                echo '('.$value.') ';
            } else {
                echo $value.' ';
            }
        }
        echo '<br>';
    }
}
echo "<br>"; */
?>



<table cellpadding=3 cellspacing=0 border=1>
<tr>
    <th>번호</th>
    <th>품명</th>
    <th>규격</th>
    <th>단위</th>
</tr>
<?php
    // 재고량이 많은 순서대로 상위 4개까지
    $sql = "SELECT * FROM milk
            ORDER BY invt DESC
            LIMIT 0, 4";
    $res = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_array($res))
    {
        echo '<tr>';
        echo '<td>'.$row[0].'</td>';
        echo '<td>'.$row[1].'</td>';
        echo '<td>'.$row[2].'</td>';
        echo '<td>'.$row[3].'</td>';
        echo '</tr>';
    }
?>
</table>

</center>


</html>