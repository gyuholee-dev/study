<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = mysqli_connect($host, $user, $pass);
    mysqli_select_db($db, "mydb");
    // mysqli_report(MYSQLI_REPORT_OFF);
?>
