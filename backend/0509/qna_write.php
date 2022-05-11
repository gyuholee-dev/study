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
    <form name="frm1" action="qna_write_ok.php" method="post">
        <table>
            <tr>
                <td>글제목</td>
                <td><input type="text" name="title"></td>
            </tr>
            <tr>
                <td>글내용</td>
                <td>
                    <textarea name="content" rows="5" cols="75"></textarea>
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