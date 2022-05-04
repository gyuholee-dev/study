<?php
session_start();
if (isset($_POST['username'])) {
    $_SESSION['user'] = $_POST['username'];
} else {
    $_SESSION['user'] = 'Guest';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script>
        $(function () {

            function getMessage() {
                $('#chat').load('message.php');
            }

            setInterval(function() {
                getMessage();
            }, 1000);


            $('#add').click(function() {
                if (frm1.message.value == '') {
                    alert('메시지를 입력하세요.');
                    frm1.message.focus();
                    return false;
                }
                $.ajax({
                    url: 'add.php',
                    type: 'post',
                    data: 'message=' + frm1.message.value
                });
                frm1.message.value = '';
                frm1.message.focus();
            });
        });
    </script>
</head>
<body>
    <div id="chat" style="height:400px; border:1px solid #666; overflow:auto;"></div>
    <form name="frm1">
        <textarea name="message" style="width:100%" rows="4"></textarea>
    </form>
    <input type="button" id="add" value="입력">
</body>
</html>
