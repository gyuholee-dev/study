<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$id = 'cust';
$action = '';
$table = 'cust';
$tableName = '고객';
$title = $tableName.' 관리';
$primeKey = 'numb';
$serchKey = '';
$keys = array();
$nameSpace = array();

$items = 999;
$page = 1;
$pages = 10;
$where = '';
$sort = 'numb';
$order = 'desc';
$start = 0;

$jobbList = array();
$sql = "SELECT cod2 AS jobb, name AS jobb_name 
        FROM code WHERE cod1 = '16'";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
    $jobbList[$a['jobb']] = $a['jobb_name'];
}

$tableData = array(
    'numb' => [
        'name' => '고객번호',
        'type' => 'CHAR',
        'length' => 2,
        'default' => 11,
        'input' => [
            ['type'=>'text','attr'=>'required readonly']
        ]
    ],
    'name' => [
        'name' => '고객명',
        'type' => 'CHAR',
        'length' => 15,
        'default' => '',
        'input' => [
            ['type'=>'text','attr'=>'required autofocus']
        ]
    ],
    'phon' => [
        'name' => '전화번호',
        'type' => 'CHAR',
        'length' => 13,
        'default' => '',
        'input' => [
            ['type'=>'text','attr'=>'required']
        ]
    ],
    'addr' => [
        'name' => '주소',
        'type' => 'VARCHAR',
        'length' => 99,
        'default' => '',
        'input' => [
            ['type'=>'text','attr'=>'']
        ]
    ],
    'jobb' => [
        'name' => '직업',
        'type' => 'CHAR',
        'length' => 2,
        'default' => '',
        'input' => [
            ['type'=>'select', 'option' => $jobbList, 'attr'=>'required']
        ]
    ],
);

$i = 0;
foreach ($tableData as $key => $value) {
    $keys[$i] = $key;
    $nameSpace[$key] = $value['name'];
    $i++;
}
