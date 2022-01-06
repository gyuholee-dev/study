<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = mysqli_connect($host, $user, $pass);
    mysqli_select_db($db, "mydb");
    
    // 에러 유발
    $sql = "INSERT INTO toyy VALUES(numb='1111')";

    // 엉터리로 입력하면 에러남
    // $res = mysqli_query($db, $sql);

    // MYSQLI_REPORT_OFF 설정을 해야 반환값을 통해 조건문 가능
    // mysqli_report(MYSQLI_REPORT_OFF);
    /* if (!mysqli_query($db, $sql)) {
        echo 'ERROR';
    } */

    // try & catch 로 에러 핸들링
    try {
        $res = mysqli_query($db, $sql);
        print_r($res);
    } catch (mysqli_sql_exception $e) {
        echo $e;
    }
    