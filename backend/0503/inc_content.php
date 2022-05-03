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
    <table>
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

    <script>
        function del(no, fname) {
            console.log(no, fname);
            if (confirm("정말 삭제하시겠습니까?")) {
                location.href = "inc_del.php?no=" + no + "&fname=" + fname;
            }
        }

    </script>

</body>
</html>
