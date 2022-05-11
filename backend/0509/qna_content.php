<?php
$no = $_GET["no"];
$conn = mysqli_connect('localhost', 'root', '', 'testdb');
$sql = "UPDATE qna SET hit = hit+1 WHERE no = '$no'";
mysqli_query($conn, $sql);

$sql = "SELECT * FROM qna WHERE no = '$no'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);

?>
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
            <td>글제목</td>
            <td><?=$row["title"]?></td>
        </tr>
        <tr>
            <td>글내용</td>
            <td><?=nl2br($row["content"])?></td>
        </tr>
        <tr>
            <td>작성자</td>
            <td><?=$row["writer"]?></td>
        </tr>
        <tr>
            <td>작성일</td>
            <td><?=$row["writeday"]?></td>
        </tr>
        <tr>
            <td>조회수</td>
            <td><?=$row["hit"]?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" value="답변" 
                    onclick="location.href='qna_write_re.php?f_no=<?=$row['f_no']?>'">
                <input type="button" value="수정" 
                    onclick="location.href='qna_modify.php?no=<?=$row['no']?>'">
                <input type="button" value="삭제"
                    onclick="location.href='qna_delete.php?no=<?=$row['no']?>&step=<?=$row['step']?>'">
            </td>
        </tr>
    </table>

</body>
</html>