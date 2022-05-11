<?php
$opt = $_GET["opt"];
$searchString = $_GET["searchString"];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "SELECT * FROM qna WHERE 1=1 ";
$whereSQL = "";
if ($opt == "title") {
    $whereSQL = "AND title LIKE '%$searchString%' ";
} else if ($opt == "content") {
    $whereSQL = "AND content LIKE '%$searchString%' ";
} else if ($opt == "all") {
    $whereSQL = "AND title LIKE '%$searchString%' OR content LIKE '%$searchString%' ";
}
$whereSQL .= "AND NOT step < -0 ";
$sql .= $whereSQL;

$res = mysqli_query($conn, $sql);
$cnt = mysqli_num_rows($res);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .readonly {
            color: #888;
        }
        #search_area {
            width: 500px;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="4">
                <div style="width:100%; display:flex; justify-content:space-between">
                    <span style="margin:0;">검색어: <?=$searchString?></span>
                    <span style="margin:0;"><?=$cnt?>개의 검색결과가 있습니다.</span>
                </div>
            </td>
        </tr>
        <tr>
            <th>글제목</th>
            <th>작성자</th>
            <th>작성일</th>
            <th>조회수</th>
        </tr>
        <?php
            while ($a = mysqli_fetch_array($res)) {
                $step = '';
                if ($a['step'] == 1 || $a['step'] == -2) {
                    $step = '&nbsp;&nbsp;&#9755; ';
                }

                $title = $step.$a["title"];
                if ($a['step'] != -1) {
                    $title = $step."<a href='qna_content.php?no=".$a["no"]."'>".$a["title"];
                }

                $class = "";
                if ($a['step'] < 0) {
                    $class = "readonly";
                }

                echo "<tr class='".$class."'>";
                echo "<td>".$title."</a></td>";
                echo "<td>".$a["writer"]."</td>";
                echo "<td>".$a["writeday"]."</td>";
                echo "<td>".$a["hit"]."</td>";
                echo "</tr>";
            }
        ?>
        <tr>
            <td colspan="4" align="center">
                <input type="button" value="목록" onclick="location.href='index.php'">
            </td>
        </tr>

    </table>
    
</body>
</html>



