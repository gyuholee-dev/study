<?php
$id = 'test';
$action = '';
$table = 'toyy';
$tableName = '장난감';
$title = $tableName.' 관리';
$primeKey = 'numb';
$serchKey = '';
$keys = array();
$nameSpace = array();

$tableData = array(
    'numb' => array(
        'name' => '장난감번호',
        'type' => 'CHAR',
        'length' => 2,
        'option' => 'NOT NULL'
    ),
    'name' => array(
        'name' => '장난감명',
        'type' => 'CHAR',
        'length' => 20,
        'option' => ''
    ),
    'stat' => array(
        'name' => '대여여부',
        'type' => 'CHAR',
        'length' => 1,
        'option' => ''
    ),
    'rent' => array(
        'name' => '대여료',
        'type' => 'INT',
        'length' => 11,
        'option' => ''
    ),
    'date' => array(
        'name' => '구입일자',
        'type' => 'CHAR',
        'length' => 10,
        'option' => ''
    ),
    'ammt' => array(
        'name' => '구입금액',
        'type' => 'INT',
        'length' => 11,
        'option' => ''
    ),
);

$i = 0;
foreach ($tableData as $key => $value) {
    $keys[$i] = $key;
    $nameSpace[$key] = $value['name'];
    $i++;
}

