<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$id = 'toyy';
$action = '';
$table = 'toyy';
$tableName = '장난감';
$title = $tableName.' 관리';
$primeKey = 'numb';
$serchKey = '';
$keys = array();
$nameSpace = array();

$tableData = array(
    'numb' => [
        'name' => '장난감번호',
        'type' => 'CHAR',
        'length' => 2,
        'default' => 11,
        'input' => [
            ['type'=>'text','attr'=>'required readonly']
        ]
    ],
    'name' => [
        'name' => '장난감명',
        'type' => 'CHAR',
        'length' => 20,
        'default' => '',
        'input' => [
            ['type'=>'text','attr'=>'required autofocus']
        ]
    ],
    'stat' => [
        'name' => '대여여부',
        'type' => 'CHAR',
        'length' => 1,
        'default' => '',
        'input' => [
            ['type'=>'radio','value'=>'H','label'=>'보유'],
            ['type'=>'radio','value'=>'R','label'=>'대여'],
        ]
    ],
    'rent' => [
        'name' => '대여료',
        'type' => 'INT',
        'length' => 11,
        'default' => '',
        'input' => [
            ['type'=>'number','attr'=>'required']
        ]
    ],
    'date' => [
        'name' => '구입일자',
        'type' => 'CHAR',
        'length' => 10,
        'default' => date('Y-m-d'),
        'input' => [
            ['type'=>'date']
        ]
    ],
    'ammt' => [
        'name' => '구입금액',
        'type' => 'INT',
        'length' => 11,
        'default' => '',
        'input' => [
            ['type'=>'number','attr'=>'required']
        ]
    ],
);

$i = 0;
foreach ($tableData as $key => $value) {
    $keys[$i] = $key;
    $nameSpace[$key] = $value['name'];
    $i++;
}

