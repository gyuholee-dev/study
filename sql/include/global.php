<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, "mydb");
// mysqli_report(MYSQLI_REPORT_OFF);

function sendMsg($msg, $url) {
    echo "<script>
        alert('$msg');
        location.href='$url';
    </script>";
}

function makeURLParam($url, $array) {
    $num = count($array);
    $i = 0;
    foreach ($array as $key => $value) {
        if ($i == 0) {
            $url = $url.'?'.$key.'='.$value;
        } else {
            $url = $url.'&'.$key.'='.$value;
        }
        $i++;
    }
    return $url;
}

function getDeptList() {
    global $db;
    $deptList = array();
    $sql = "SELECT * FROM dept";
    $res = mysqli_query($db, $sql);
    while ($a = mysqli_fetch_row($res)) {
        $deptList[$a[0]] = $a[1];
    }
    return $deptList;
}

function getAllRecords($table) {
    global $db;
    $records = array();
    $sql = "SELECT * FROM $table";
    $res = mysqli_query($db, $sql);
    while ($a = mysqli_fetch_row($res)) {
        $records[$a[0]] = array();
        foreach ($a as $key => $value) {
            $records[$a[0]][$key] = $value;
        }
    }
    return $records;
}

function getCountRecords($table) {
    global $db;
    $sql = "SELECT COUNT(*) FROM $table";
    $res = mysqli_query($db, $sql);
    $a = mysqli_fetch_row($res);
    return $a[0];
}
