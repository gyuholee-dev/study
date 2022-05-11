<?php
$no = $_GET["no"];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');
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
    <form name="frm1" action="qna_modify_ok.php" method="post">
        <table>
            <tr>
                <td>글제목</td>
                <td>
                  <input type="hidden" name="no" value="<?=$no?>">
                  <input type="text" name="title" value="<?=$row['title']?>">
                </td>
            </tr>
            <tr>
                <td>글내용</td>
                <td>
                    <textarea name="content" rows="5" cols="75"><?=$row['content']?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit">
                </td>
            </tr>
        </table>
    </form>

</body>
</html>