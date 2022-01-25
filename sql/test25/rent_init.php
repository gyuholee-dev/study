<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$id = 'rent';
$action = '';
$table = 'rent';
$tableName = '대여반납';
$title = $tableName.' 관리';
$primeKey = 'seqn';
$serchKey = '';
$keys = array();
$nameSpace = array();

$items = 10;
$page = 1;
$pages = 10;
$where = '';
$sort = 'date';
$order = 'desc';
$start = 0;

$custList = array();
$sql = "SELECT numb AS cust, name AS cust_name 
        FROM cust";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
    $custList[$a['cust']] = $a['cust_name'];
}

$toyyList = array();
$sql = "SELECT numb AS toyy, name AS toyy_name 
        FROM toyy";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
    $toyyList[$a['toyy']] = $a['toyy_name'];
}

$tableData = array(
    'seqn' => [
        'name' => '일련번호',
        'type' => 'INT',
        'length' => 99,
        'default' => '',
        'input' => [
            ['type'=>'hidden']
        ]
    ],
    'date' => [
        'name' => '대여일자',
        'type' => 'CHAR',
        'length' => 10,
        'default' => date('Y-m-d'),
        'input' => [
            ['type'=>'date']
        ]
    ],
    'cust' => [
        'name' => '고객명',
        'type' => 'CHAR',
        'length' => 2,
        'default' => '',
        'input' => [
            ['type'=>'select', 'option' => $custList, 'attr'=>'required']
        ]
    ],
    'toyy' => [
        'name' => '장난감명',
        'type' => 'CHAR',
        'length' => 2,
        'default' => '',
        'input' => [
            ['type'=>'select', 'option' => $toyyList, 'attr'=>'required']
        ]
    ],
    'stat' => [
        'name' => '대여상태',
        'type' => 'CHAR',
        'length' => 1,
        'default' => '',
        'input' => [
            ['type'=>'radio','value'=>'R','label'=>'대여'],
            ['type'=>'radio','value'=>'B','label'=>'반납'],
        ]
    ],
    'retn' => [
        'name' => '반납일자',
        'type' => 'CHAR',
        'length' => 10,
        'default' => date('Y-m-d'),
        'input' => [
            ['type'=>'date']
        ]
    ],
);

$i = 0;
foreach ($tableData as $key => $value) {
    $keys[$i] = $key;
    $nameSpace[$key] = $value['name'];
    $i++;
}
