<?php
session_start();
if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $group = ceil($page/10);
} else {
    $page = 1;
    $group = 1;
}

$startRow = ($page - 1) * 10;
$db = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "SELECT * FROM notice 
        ORDER BY no DESC 
        LIMIT $startRow, 10 ";
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
                $groupCount = ceil($pageCount/10);

                $startPage = ($group - 1) * 10 + 1;
                $endPage = $startPage + 9;

                if ($page > 1) {
                    echo "<a href='notice10.php?page=1'>FIRST </a>";
                } else {
                    echo "<span style='color:grey;'>FIRST </span>";
                }
                if ($group > 1) {
                    $prevPage = ($group - 2) * 10 + 1;
                    echo "<a href='notice10.php?page=$prevPage'>PREV</a> ";
                } else {
                    echo "<span style='color:grey;'>PREV </span>";
                }
                for ($i=$startPage; $i <= $endPage; $i++) {
                    if ($i > $pageCount) {
                        break;
                    }
                    if ($i == $page) {
                        $style="font-weight:bold;color:red;";
                    } else {
                        $style="";
                    }
                    echo "<a href='notice10.php?page=$i' style='$style'>[$i]</a> ";
                }
                if ($group < $groupCount) {
                    $nextPage = $group * 10 + 1;
                    echo "<a href='notice10.php?page=$nextPage'>NEXT </a>";
                } else {
                    echo "<span style='color:grey;'>NEXT </span>";
                }
                if ($page != $pageCount) {
                    echo "<a href='notice10.php?page=$pageCount'>LAST</a>";
                } else {
                    echo "<span style='color:grey;'>LAST</span>";
                }


            ?>
            </td>
        </tr>
        <?php
            if (isset($_SESSION["id"]) && $_SESSION["id"] == "admin") {
                // 관리자일 경우에만 공지사항을 올릴수 있도록 처리한다
            }
        ?>
        <tr>
            <td colspan="5" align="center">
                <input type="button" value="공지사항 추가" 
                    onclick="location.href='notice_write.php'">
            </td>
        </tr>
    </table>
</body>
</html>
