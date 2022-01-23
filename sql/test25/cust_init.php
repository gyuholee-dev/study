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
            ['type'=>'text','attr'=>'required']
        ]
    ],
    'jobb' => [
        'name' => '직업',
        'type' => 'CHAR',
        'length' => 2,
        'default' => '',
        'input' => [
            ['type'=>'select','attr'=>'required']
        ]
    ],
);

$i = 0;
foreach ($tableData as $key => $value) {
    $keys[$i] = $key;
    $nameSpace[$key] = $value['name'];
    $i++;
}
