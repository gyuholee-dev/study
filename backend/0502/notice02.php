<?php

$db = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "SELECT * FROM notice 
        ORDER BY no DESC ";
$res = mysqli_query($db, $sql);

?>
<!-- HTML START -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <table>
        <tr>
            <th>글번호</th>
            <th>글제목</th>
            <th>작성자</th>
            <th>작성일</th>
            <th>조회수</th>
        </tr>
        <?php
            while ($a = mysqli_fetch_array($res)) {
                echo "<tr>";
                echo "<td>".$a["no"]."</td>";
                echo "<td>".$a["title"]."</td>";
                echo "<td>".$a["writer"]."</td>";
                echo "<td>".$a["writeday"]."</td>";
                echo "<td>".$a["hit"]."</td>";
                echo "</tr>";
            }
        ?>
        <tr>
            <td colspan="5" align="center">
            <?php
                $sql2 = "SELECT COUNT(*) AS cnt FROM notice";
                $res2 = mysqli_query($db, $sql2);
                $row2 = mysqli_fetch_array($res2);
                $pageCount = ceil($row2["cnt"]/10);

                for ($i=1; $i <= $pageCount; $i++) {
                    echo "<a href='notice02.php'>[$i]</a> ";
                }

            ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="center">
                <input type="button" value="공지사항 추가" 
                    onclick="location.href='notice_write.php'">
            </td>
        </tr>
    </table>
</body>
</html>
