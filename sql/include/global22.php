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
$id = 'test22';
$action = '';
$table = 'rewd';
$tableName = '상벌';
$title = $tableName.' 관리';
$primeKey = 'seqn';
$serchKey = 'empl';

$items = 10;
$page = 1;
$pages = 10;
$where = '';
$sort = 'date';
$order = 'desc';
$start = 0;

$nameSpace = array(
    'seqn' => '순서',
    'empl' => '사원번호',
    'date' => '상벌일자',
    'kind' => '구분',
    'code' => '상벌코드',
    'resn' => '상벌사유',
    'remk' => '비고',
    'empl_name' => '사원명',
    'code_name' => '상벌내용',
);

$tableDesc = array(
    'seqn' => 'INT AUTO_INCREMENT',
    'empl' => 'CHAR(4)',
    'date' => 'CHAR(10)',
    'kind' => 'CHAR(1)',
    'code' => 'CHAR(2)',
    'resn' => 'CHAR(40)',
    'remk' => 'CHAR(40)',
    'PRIMARY' => 'KEY(seqn)',
);

// Functions
function makeCreateSql() {
    global $table;
    global $tableDesc;
    $sql = '';
    $i = 0;
    $cnt = count($tableDesc);
    foreach ($tableDesc as $key => $value) {
        $sql = $sql.$key.' '.$value;
        if ($i != $cnt-1) {
            $sql = $sql.', ';
        }
        $i++;
    }
    return $sql;
}

function sendMsg($msg, $url) {
    echo "<script>
            alert('$msg');
            location.href='$url';
          </script>";
}

function tableExist($table) {
    global $db;
    $sql = "SHOW TABLES LIKE '$table'";
    $res = mysqli_query($db, $sql);
    if (mysqli_num_rows($res) != 0) {
        return true;
    }
    return false;
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
function getURLParam($except=false, $insert=false) {
    $urls = '';
    $reqUrl = $_SERVER['REQUEST_URI'];
    if (strpos($reqUrl, '?') !== false) {  
        $urls = explode('?', $reqUrl);
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
    }
    
    if ($insert !== false) {
        if ($urls !== '') {
            $urls = $insert.'&'.$urls;
        } else {
            $urls = $insert;
        }
    }

    if ($urls !== '') {
        return '?'.$urls;
    } else {
       return ''; 
    }
}