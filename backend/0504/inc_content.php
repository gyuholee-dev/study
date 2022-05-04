<?php
  $no = $_GET['no'];
  $conn = mysqli_connect('localhost', 'root', '', 'testdb');

  // 조회수 증가
  $sql = "UPDATE inc SET hit = hit + 1 WHERE no = '$no'";
  mysqli_query($conn, $sql);
  
  // no 게시글 조회
  $sql = "SELECT * FROM inc WHERE no = '$no'";
  $res = mysqli_query($conn, $sql);
  $a = mysqli_fetch_array($res);

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
        
    <table class="table">
        <tr>
            <td>글번호</td>
            <td><?=$a['no']?></td>
        </tr>
        <tr>
            <td>조회수</td>
            <td><?=$a['hit']?></td>
        </tr>
        <tr>
            <td>작성자</td>
            <td><?=$a['writer']?></td>
        </tr>
        <tr>
            <td>글제목</td>
            <td><?=$a['title']?></td>
        </tr>
        <tr>
            <td>글내용</td>
            <td><?=$a['content']?></td>
        </tr>
        <tr>
            <td>첨부파일</td>
            <td>
                <?php
                    $file = $a['fname'];
                    echo "<a href='down.php?fname=$file'><b style='color:red;'>$file</b></a>";    
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" value="삭제" onclick="del('<?=$no?>', '<?=$a['fname']?>')">
                <input type="button" value="메인" onclick="location.href='inc.php'">
            </td>
        </tr>
    </table>

    <table class="table">
    <?php
        // 댓글 리스트
        $sql = "SELECT * FROM inc_re WHERE p_no = '$no' ";
        $res = mysqli_query($conn, $sql);
        while ($b = mysqli_fetch_array($res)) {
            $href = "inc_re_del.php?p_no=".$no."&no=".$b['no'];
            echo "<tr>";
            echo "<td>".$b["content"]."</td>";
            echo "<td width='80'>";
            echo $b["writer"];
            echo '<input type="button" value="x" onclick="location.href=\''.$href.'\'">';
            echo "</td>";
            echo "</tr>";
        }
    ?>
    </table>

    <form name="frm1" method="post" action="inc_re_ok.php">
        <table class="table">
            <tr>
                <td style="width:100%"><input style="width:100%" name="comment" type="text"></td>
                <td>
                    <input type="hidden" name="p_no" value="<?=$no?>">
                    <input type="button" value="댓글" onclick="send()">
                </td>
            </tr>
        </table>
    </form>

    <script>
        function del(no, fname) {
            console.log(no, fname);
            if (confirm("정말 삭제하시겠습니까?")) {
                location.href = "inc_del.php?no=" + no + "&fname=" + fname;
            }
        }
        
        function send() {
            if (frm1.comment.value=="") {
                alert("댓글을 입력하세요.");
                frm1.comment.focus();
                return false;
            }
            document.frm1.submit();
        }

    </script>

</body>
</html>
