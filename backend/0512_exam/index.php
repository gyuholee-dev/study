<?php
// 초기화 -------------------------------------------------------
session_start();

// 글로벌 변수
global $DB;
global $USER;
global $DO;
global $NO;
global $PAGE;

// DB 연결
$DB = mysqli_connect('localhost', 'root', '', 'testdb');

// 유저 세션
if (isset($_SESSION['user'])) {
    $USER = $_SESSION['user'];
}

// 리퀘스트
$DO = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'view';
$NO = isset($_REQUEST['sns_no']) ? $_REQUEST['sns_no'] : 1;
$PAGE = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

// sns 마지막 넘버
$sql = "SELECT MAX(sns_no) FROM sns ORDER BY sns_no DESC LIMIT 1";
$result = mysqli_query($DB, $sql);
if (mysqli_num_rows($result) > 0) {
    $lastNum = mysqli_fetch_array($result)[0];
}
if (!isset($_REQUEST['sns_no'])) {
    $NO = $lastNum;
}

// -------------------------------------------------------------

// 입력 처리

if (isset($_POST['confirm'])) {

    // 로그인
    if ($_POST['do'] == 'login') {
        $sql = "SELECT * FROM member 
                WHERE id = '{$_POST['id']}' AND pw = '{$_POST['pw']}'";
        $result = mysqli_query($DB, $sql);
        if (mysqli_num_rows($result) > 0) {
            $USER = mysqli_fetch_array($result);
            $_SESSION['user'] = $USER;
            header('Location: index.php');
        } else {
            echo '<script>alert("아이디 또는 비밀번호가 잘못되었습니다."); location.href="index.php";</script>';
        }
    }
    // 로그아웃
    elseif ($_POST['do'] == 'logout') {
        unset($_SESSION['user']);
        header('Location: index.php');
    }
    // 글 입력
    else if ($_POST['do'] == 'post') {
        $message = $_POST['message'];
        $writer = $USER['name'];
        $writeday = time();
        $uploadfile = '';
        if (isset($_FILES['userfile'])) {
            // 파일 업로드
            $fileName = basename($_FILES['userfile']['name']);
            $uploaddir = './files/';
            @mkdir($uploaddir); // 디렉토리 생성
            $uploadfile = $uploaddir . $fileName;
            move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
        }

        $sql = "INSERT INTO sns (writer, writeday, file, message)
                VALUES ('$USER', '$writeday', '$uploadfile', '$message')";
        echo $sql;
        mysqli_query($DB, $sql);
        header('Location: index.php');
        
    }
    // 리플 입력
    elseif ($_POST['do'] == 'reply') {
        $message = $_POST['message'];
        $writer = $USER['name'];
        $writeday = time();

        $sql = "INSERT INTO sns_re (writer, writeday, message, sns_no)
                VALUES ('$USER', '$writeday', '$message', $NO)";
        mysqli_query($DB, $sql);
        header('Location: index.php');

    }

}

// -------------------------------------------------------------

// 페이지 처리
$sql = "SELECT COUNT(*) FROM sns";
$res = mysqli_query($DB, $sql);
$pageCount = mysqli_fetch_array($res)[0];
$start = $PAGE - 1;

// 글 출력 처리
// $sql = "SELECT * FROM sns WHERE sns_no = $NO ";
$sql = "SELECT * FROM sns LIMIT $start, 1";
$res = mysqli_query($DB, $sql);
$data = mysqli_fetch_assoc($res);

$NO = $data['sns_no'];

// 답글 출력 처리
$sql = "SELECT * FROM sns_re WHERE sns_no = $NO ";
$re_res = mysqli_query($DB, $sql);

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
    <header>
        <?php if ($USER) { ?>
            <div class="buttons">
                <input type="button" value="글쓰기" onclick="openSlide(post_write, postWrite)">
            </div>
            <form name="memberLogout" method="post" class="usermenu" style="width:initial;">
                <input type="hidden" name="do" value="logout">
                <input type="hidden" name="confirm" value="true">
                <input type="submit" value="로그아웃">
            </form>
        <?php } else { ?>
            <form name="memberLogin" method="post">
                <input type="hidden" name="do" value="login">
                <input type="hidden" name="confirm" value="true">
                <label>member id<input type="text" name="id"></label>
                <label>password<input type="password" name="pw"></label>
                <input type="submit" value="로그인">
            </form>
        <?php } ?>
    </header>

    <main>
        <!-- 포스트 입력 -->
        <?php if ($USER) { ?>
            <section id="post_write">
                <h3 class="header">글 쓰기</h3>
                <form name="postWrite" method="post" enctype="multipart/form-data" >
                    <div class="content">
                        <textarea name="message"></textarea>
                    </div>
                    <div class="file">
                        <input type="hidden" name="do" value="post">
                        <input type="hidden" name="confirm" value="true">
                        <input type="file" name="userfile">
                    </div>
                    <div class="buttons">
                        <input type="button" value="글올리기" onclick="checkPost(postWrite)">
                        <input type="button" value="취소" onclick="closeSlide(post_write, form)">
                    </div>
                </form>
            </section>
        <?php } ?>

        <!-- 포스트 출력 -->
        <section id="post_view">
            <div class="info">
                <span class="writeday"><?= date("Y년m월d일",$data['writeday']) ?></span>
            </div>
            <article class="content">
                <div class="photo">
                    <img src="<?= $data['file'] ?>">
                </div>
                <div class="message">
                    <?= $data['message'] ?>
                </div>
            </article>

            <!-- 리플 입력 -->
            <?php if ($USER) { ?>
                <form name="replyWrite" method="post" class="inputbox">
                    <input type="hidden" name="do" value="reply">
                    <input type="hidden" name="confirm" value="true">
                    <input type="text" name="message">
                    <input type="button" value="답글" onclick="checkReply(replyWrite)">
                </form>
            <?php } ?>
            
            <article class="reply">
            <?php
                if (mysqli_num_rows($re_res) > 0) {
                    while ($re_data = mysqli_fetch_assoc($re_res)) {
                        echo "<div class='message'>";
                        echo '<span class="text">'.$re_data['message'].'</span>';
                        echo '<span class="writer">by '.$re_data['writer'].'</span>';
                        echo "</div>";
                    }
                } else {
                    echo "<div class='message'>";
                    echo '<span class="text">답글이 없습니다.</span>';
                    echo '<span class="writer"></span>';
                    echo "</div>";
                }
            ?>
            </article>

        </section>

    </main>

    <footer>
    <?php
        // 페이지 처리
        echo '<input type="button" value="이전">';
        echo '<div class="pagenav">';
            // [1] [2] [3] [4] [5]
        for ($i = 1; $i <= $pageCount; $i++) {
            if ($i == $PAGE) {
                echo '<span class="current">'.$i.'</span>';
            } else {
                echo '<a href="index.php?page='.$i.'">['.$i.']</a>';
            }
        }
        echo '</div>';
        echo '<input type="button" value="다음">';
    ?>
    </footer>

    <script src="script.js"></script>

</body>
</html>