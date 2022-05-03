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
            $db = mysqli_connect('localhost', 'root', '', 'testdb');
            $sql = "SELECT * FROM inc ORDER BY no DESC";
            $res = mysqli_query($db, $sql);

            while ($a = mysqli_fetch_array($res)) {
                echo "<tr>";
                echo "<td>".$a['no']."</td>";
                echo "<td>";
                echo "<a href='inc_content.php?no=".$a['no']."'>".$a['title']."</a>";  
                echo "</td>";
                echo "<td>".$a['writer']."</td>";
                echo "<td>".$a['writeday']."</td>";
                echo "<td>".$a['hit']."</td>";
                echo "</tr>";
            }
        ?>
        <tr>
            <td colspan="5" align="center">
                <input type="button" value="자료추가" onclick="location.href='inc_write.php'">
            </td>
        </tr>
    </table>
</body>
</html>