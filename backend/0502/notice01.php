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
            <td>글번호</td>
            <td>글제목</td>
            <td>작성자</td>
            <td>작성일</td>
            <td>조회수</td>
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
