<?php
session_start();

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
    <header>
    <?php
        if (isset($_SESSION['id'])) {
            echo '<a href="logout.php">로그아웃</a>';
        } else {
            echo '<a href="login.php">로그인</a>';
        }
    ?>
    </header>
    
    <main id="content">
        <br>
        <form name="frm1" method="post" action="login_ok.php">
            <table>
                <tr>
                    <td colspan="2" align="center">로그인</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><input type="text" name="id" required></td>
                </tr>
                <tr>
                    <td>PW</td>
                    <td><input type="password" name="pw" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="submit" value="로그인">
                        <input type="reset" value="재작성">
                    </td>
                </tr>
            </table>
        </form>
        <br>
    </main>

</body>
</html>
