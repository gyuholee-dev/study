<?php
// OPTIONS
// mysqli_report(MYSQLI_REPORT_OFF);
// ini_set('display_errors', 0);

// DB
$host = "localhost";
$user = "root";
$pass = "";
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, "mydb");
