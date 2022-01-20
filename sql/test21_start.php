<?php

$whereSql = '';
$sortSql = '';
$orderSql = '';
$limitSql = '';

if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$sql = "SELECT COUNT(*) FROM $table";
if (isset($_REQUEST['where']) && $_REQUEST['where'] != '') {
    $where = $_REQUEST['where'];
    $whereSql = " WHERE $serchKey = '$where'";
}
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);

$pages = ceil($a[0]/$items);
$start = ($page-1)*$items;
$limitSql = " LIMIT $start, $items";

if (isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
}
$sortSql = ' ORDER BY '.$sort;

if (isset($_REQUEST['order'])) {
    $order = $_REQUEST['order'];
}
if ($order == 'asc') {
    $orderSql = ' ASC';
} elseif ($order == 'desc') {
    $orderSql = ' DESC';
}

$sql = "SELECT trip.*, 
        empl.name AS numb_name, 
        code.name AS plce_name 
        FROM trip
        JOIN empl ON trip.numb = empl.numb
        JOIN code ON trip.plce = code.cod2 
        AND code.cod1 = '13'";

if ($action == 'delete') {
    $target = $_REQUEST[$primeKey];
    $whereSql = " WHERE $primeKey='$target'";
    $sql = $sql.$whereSql;
} else {
    $sql = $sql.$whereSql.$sortSql.$orderSql.$limitSql;
}

$res = mysqli_query($db, $sql);