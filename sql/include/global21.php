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

// GLOBAL Value
$id = 'test21';
$action = '';
$table = 'trip';
$tableName = '사원출장';
$title = $tableName.' 관리';
$primeKey = 'serl';
$serchKey = 'plce';

$items = 10;
$page = 1;
$pages = 10;
$where = '';
$sort = 'date';
$order = 'desc';
$start = 0;

$nameSpace = array(
    'serl' => '순서',
    'numb' => '사번',
    'date' => '출장일자',
    'days' => '출장일수',
    'plce' => '출장지',
    'purp' => '출장목적',
    'tran' => '교통숙박비',
    'food' => '식비',
    'etcs' => '여비',
    'comp' => '동행자',
    'plce_name' => '출장지',
    'numb_name' => '출장자'
);


// Functions
function sendMsg($msg, $url) {
    echo "<script>
            alert('$msg');
            location.href='$url';
          </script>";
}

function getAllRecords($table, $pkey=true) {
    global $db;
    $records = array();
    $sql = "SELECT * FROM $table";
    $res = mysqli_query($db, $sql);
    $i = 0;
    while ($a = mysqli_fetch_row($res)) {
        if ($pkey == true) {
            $records[$a[0]] = array();
            foreach ($a as $key => $value) {
                $records[$a[0]][$key] = $value;
            }
        } elseif ($pkey == false) {
            $records[$i] = array();
            foreach ($a as $key => $value) {
                $records[$i][$key] = $value;
            }
            $i++;
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

function getThisFile() {
    if(strpos($_SERVER['REQUEST_URI'], '?') !== false) {  
        $urls = explode('?', $_SERVER['REQUEST_URI']);
        $urls = $urls[0];
    } else {
        $urls = $_SERVER['REQUEST_URI'];
    }
    $urls = array_reverse(explode('/', $urls));
    $thisFile = trim($urls[0]);
    return $thisFile;
}
/* 
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
 */
function getURLParam($except=false) {
    if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {  
        $urls = explode('?', $_SERVER['REQUEST_URI']);
        $urls = $urls[1];
        if ($except !== false) {
            $urls = explode('&', $urls);
            foreach ($urls as $key => $value) {
                if (strpos($value, $except.'=') !== false) {
                    unset($urls[$key]);
                }
            }
            $urls = implode('&', $urls);
        }
        return '?'.$urls;
    } else {
        return '';
    }
}