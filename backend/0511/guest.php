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
    <style>
        #inputData {
            width: 800px;
            border: 1px solid;
            padding: 5px;
        }
        #data {
            width: 800px;
            border: 1px solid;
            padding: 5px;
        }
        #page {
            width: 800px;
            padding: 5px;
            text-align: center;
        }
    </style>
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
        <form name="frm1" method="post">
            <br>
            <div id="inputData">
                <h3>방명록 쓰기</h3>
                <textarea name="memo" cols="80" rows="5"></textarea>
                <?php if (isset($_SESSION['id'])) { ?>
                <input type="button" value="글남기기" onclick="gotoGuest()">
                <?php } ?>
            </div>

            <!-- <div id="data"> -->
            <?php
                if  (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $start = ($page - 1) * 5;

                $conn = mysqli_connect('localhost', 'root', '', 'testdb');
                $sql = "SELECT * FROM guest ORDER BY no DESC LIMIT $start, 5";
                $res = mysqli_query($conn, $sql);

                $i = 0;
                while ($row = mysqli_fetch_array($res)) {
                    $i++;
                    echo '<div id="data">';
                    echo '<p>'.nl2br($row['memo']).' by '.$row['writer'].' ';
                    if (isset($_SESSION['id']) && $_SESSION['id'] == $row['writer']) {
                        echo '<a style="color:red;" href="#" onclick="deleteGuest('.$row['no'].','.$page.')">X</a></p>';
                    } else {
                        echo '</p>';
                    }
                        // 답글
                        $no = $row['no'];
                        $sql3 = "SELECT * FROM guest_re WHERE p_no = $no"; // 테이블 오류나면 테이블명 체크
                        $res3 = mysqli_query($conn, $sql3);
                        while ($row3 = mysqli_fetch_array($res3)) {
                            echo '<p>ㄴ'.nl2br($row3['memo']).' by '.$row3['writer']. ' ';
                            if (isset($_SESSION['id']) && $_SESSION['id'] == $row3['writer']) {
                                echo '<a style="color:red;" href="#" onclick="deleteGuest_re('.$row3['no'].','.$page.')">X</a></p>';
                            } else {
                                echo '</p>';
                            }
                        }
                        if (isset($_SESSION['id'])) {
                            echo '<a href="#" onclick="send(redata'.$i.','.$row['no'].','.$page.')"><b style="color:red;">답글작성</b></a>';
                        }
                        // 답글 입력 삽입 위치
                        echo '<div id="redata'.$i.'"></div>';
                    echo '</div>';
                }
            ?>
            <!-- </div> -->

            <!-- 삭제 히든인풋 -->
            <input type="hidden" name="deleteGuest_target">
            <input type="hidden" name="deleteGuest_re_target">
            <input type="hidden" name="page">

            <div id="page">
            <?php
                // 테스트를 위해 글 5개 이상 작성해볼것
                $sql2 = "SELECT COUNT(*) AS cnt FROM guest";
                $res2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_array($res2);
                $pageCount = ceil($row2['cnt'] / 5);
                for ($i=1; $i <= $pageCount; $i++) { 
                    echo '<a href="guest.php?page='.$i.'">'.$i.'</a>';
                    echo '&nbsp;&nbsp;'; // 공백 추가
                }
            ?>
            </div>

            <br>
        </form>
    </main>

    <script>
        function gotoGuest() {
            if (frm1.memo.value == "") {
                alert("내용을 입력하세요.");
                frm1.memo.focus();
                return false;
            }
            document.frm1.action = "guest_write_ok.php";
            document.frm1.submit();
        }

        function send(p, p_no, page) {
            console.log(p, p_no, page); // 테스트
            
            if (document.getElementById('redata1')) {
                document.getElementById('redata1').innerHTML = "";
            }
            if (document.getElementById('redata2')) {
                document.getElementById('redata2').innerHTML = "";
            }
            if (document.getElementById('redata3')) {
                document.getElementById('redata3').innerHTML = "";
            }
            if (document.getElementById('redata4')) {
                document.getElementById('redata4').innerHTML = "";
            }
            if (document.getElementById('redata5')) {
                document.getElementById('redata5').innerHTML = "";
            }

            // document.getElementById(p).innerHTML = '<input type="text" name="re" size="80">';
            p.innerHTML = 
                '<input type="text" name="re" size="80"> '+
                '<input type="hidden" name="p_no" value="'+p_no+'">'+
                '<input type="hidden" name="page" value="'+page+'">'+
                '<a href="#" onclick="resend()">답글</a> '+
                '<a href="#" onclick="reclose()">닫기</a>';

        }

        function resend() {
            if (frm1.re.value == "") {
                alert("내용을 입력하세요.");
                frm1.re.focus();
                return false;
            }
            document.frm1.action = "guest_re_ok.php";
            document.frm1.submit();
        }

        function reclose() {
            if (document.getElementById('redata1')) {
                document.getElementById('redata1').innerHTML = "";
            }
            if (document.getElementById('redata2')) {
                document.getElementById('redata2').innerHTML = "";
            }
            if (document.getElementById('redata3')) {
                document.getElementById('redata3').innerHTML = "";
            }
            if (document.getElementById('redata4')) {
                document.getElementById('redata4').innerHTML = "";
            }
            if (document.getElementById('redata5')) {
                document.getElementById('redata5').innerHTML = "";
            }
        }

        function deleteGuest(no, page) {
            if (confirm("삭제하시겠습니까?")) {
                document.frm1.deleteGuest_target.value = no;
                document.frm1.page.value = page;
                document.frm1.action = "guest_delete_ok.php";
                document.frm1.submit();
            } else {
                return false;
            }
        }

        function deleteGuest_re(no, page) {
            if (confirm("삭제하시겠습니까?")) {
                document.frm1.deleteGuest_re_target.value = no;
                document.frm1.page.value = page;
                document.frm1.action = "guest_re_delete_ok.php";
                document.frm1.submit();
            } else {
                return false;
            }
        }

    </script>

</body>
</html>
