<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = mysqli_connect($host, $user, $pass);
    mysqli_select_db($db, "mydb");

    // memb 테이블 생성
    /* $sql = "CREATE TABLE memb
              (
                code char(3) not null,
                name char(20),
                gend char(60),
                primary key(code)
              )";
    mysqli_query($db, $sql);
    echo "Table 생성을 완료했습니다."; */

    // 레코드 입력
    /* $sql = "INSERT INTO memb
              VALUES('111', '도영해', '남자')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO memb
              VALUES('112', '김선영', '여자')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO memb
              VALUES('113', '박태균', '남자')";
    mysqli_query($db, $sql);
    echo "3 레코드 인서트 완료"; */

    // 코드가 111인 사람의 이름을 도용호로 수정
    /* $sql = "UPDATE memb
              SET name = '도용호'
              WHERE code = '111'
            ";
    mysqli_query($db, $sql);
    echo "수정 완료"; */

    // code 가 113인 레코드를 삭제
    /* $sql = "DELETE from memb
              WHERE code = '113'
            ";
    mysqli_query($db, $sql);
    echo "code 113 삭제 완료"; */


    // 레코드 확인
    /* $result_set = mysqli_query($db, "select * from memb");
    while ($row = mysqli_fetch_assoc($result_set)){
        print_r($row);
        echo "<br>";
    } */
    /* $result_set = mysqli_query($db, "select * from memb");
    while ($row = mysqli_fetch_row($result_set)){
        print_r($row);
        echo "<br>";
    } */


    $sql = "select * from memb";
    $res = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_array($res)) {
        // print_r($row);
        // echo "<br>";
        echo "$row[0] $row[1] $row[2]</br>";
    }
