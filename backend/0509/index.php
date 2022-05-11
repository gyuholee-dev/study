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
            <th>글제목</th>
            <th>작성자</th>
            <th>작성일</th>
            <th>조회수</th>
        </tr>
        <?php
            $conn = mysqli_connect('localhost', 'root', '', 'testdb');
            $sql = "SELECT * FROM qna ORDER BY f_no DESC, no ASC";
            $res = mysqli_query($conn, $sql);

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
                <input type="button" value="글쓰기" onclick="location.href='qna_write.php'">
            </td>
        </tr>
    </table>
    <div id="search_area">
        <form name="frm1" method="get">
            <select name="opt">
                <option value="title">제목</option>
                <option value="content">내용</option>
                <option value="all">제목+내용</option>
            </select>
            <input type="text" name="searchString">
            <input type="button" value="검색" onclick="search()">
        </form>
    </div>

    <script>
        function search() {
            location.href = "qna_search.php?opt="+frm1.opt.value+"&searchString="+frm1.searchString.value;
        }

    </script>

</body>
</html>