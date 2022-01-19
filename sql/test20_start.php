<?php
$items = 10;
$page = 1;
$pages = 10;
$start = 0;
$sort = 'seqn';
$order = 'desc';
$where = '';

if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$sql = "SELECT COUNT(*) FROM educ";
$whereSql = '';
if (isset($_REQUEST['where']) && $_REQUEST['where'] != '') {
    $where = $_REQUEST['where'];
    $whereSql = " WHERE educ = '$where'";
}
$sql = $sql.$whereSql;

$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);
$start = ($page-1)*$items;

// echo '$items: '.$items.'<br>';
// echo '$page: '.$page.'<br>';
// echo '$pages: '.$pages.'<br>';
// echo '$start: '.$start.'<br>';

$deptList = getAllRecords('dept');
$gradList = array();
$educList = array();

$sql = "SELECT cod2, name FROM code WHERE cod1 = '11'";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    foreach ($a as $key => $value) {
        $gradList[$a[0]] = $a[1];
    }
}
$sql = "SELECT DISTINCT(educ) FROM educ";
$res = mysqli_query($db, $sql);
for ($i=0; $i < mysqli_num_rows($res) ; $i++) { 
    $educList[$i] = mysqli_fetch_row($res)[0];
}

// $sql = "SELECT * FROM educ 
//         ORDER BY numb DESC 
//         LIMIT $start, $items";

$sql = "SELECT educ.*, empl.name AS numb_name, code.name AS plce_name FROM educ
        JOIN empl ON educ.numb = empl.numb
        JOIN code ON educ.plce = code.cod2 AND code.cod1 = '13'";

$sortSql = ' ORDER BY seqn';
if (isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
    $sortSql = ' ORDER BY '.$_REQUEST['sort'];
}
$orderSql = ' DESC';
if (isset($_REQUEST['order'])) {
    $order = $_REQUEST['order'];
    if ($_REQUEST['order'] == 'asc') {
        $orderSql = ' ASC';
    } elseif ($_REQUEST['order'] == 'desc') {
        $orderSql = ' DESC';
    }
}
$limitSql = " LIMIT $start, $items";

if ($mode == 'RECORD') {
    $whereSql = " WHERE $target='$targetVal'";
    $sql = $sql.$whereSql;
} else {
    $sql = $sql.$whereSql.$sortSql.$orderSql.$limitSql;
}
$res = mysqli_query($db, $sql);
