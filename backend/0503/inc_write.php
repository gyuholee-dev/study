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
<form enctype="multipart/form-data" name="frm1" method="post" action="inc_write_ok.php">
    <table>
        <tr>
            <td>작성자</td>
            <td><input type="text" name="writer" size="50"></td>
        </tr>
        <tr>
            <td>글제목</td>
            <td><input type="text" name="title" size="50"></td>
        </tr>
        <tr>
            <td>글내용</td>
            <td><textarea name="content" cols="75" rows="15"></textarea></td>
        </tr>
        <tr>
            <td>첨부파일</td>
            <td><input type="file" name="userfile" size="50"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" value="전송" onclick="send()">
                <input type="reset" value="취소">
                <input type="button" value="메인" onclick="location.href='inc.php'">
            </td>
        </tr>
    </table>
</form>

<script>
    function send() {
        if (frm1.writer.value == "") {
            alert("작성자를 입력하세요.");
            frm1.writer.focus();
            return false;
        }
        if (frm1.title.value == "") {
            alert("제목을 입력하세요.");
            frm1.title.focus();
            return false;
        }
        if (frm1.content.value == "") {
            alert("내용을 입력하세요.");
            frm1.content.focus();
            return false;
        }
        if (frm1.userfile.value == "") {
            alert("파일을 선택하세요.");
            frm1.userfile.focus();
            return false;
        }
        document.frm1.submit();
    }

</script>


</body>
</html>