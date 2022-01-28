<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

// $id = 'group';
$table = 'grop';
$tableName = '걸그룹';
$title = $tableName.' 관리';
$primeKey = 'numb';
$serchKey = 'kind';
$action = 'start';

$keys = array();
$nameSpace = array();

$items = 5;
$page = 1;
$pages = 10;
$where = '';
$sort = 'numb';
$order = 'desc';
$start = 0;

/* $tableData = array(
  'numb' => [
    'name' => '작품번호',
    'type' => 'CHAR',
    'length' => 2,
    'default' => 11,
    'input' => [
      ['type'=>'text','attr'=>'required readonly']
    ]
  ],
  'name' => [
    'name' => '작품명',
    'type' => 'CHAR',
    'length' => 30,
    'default' => '',
    'input' => [
      ['type'=>'text','attr'=>'required autofocus']
    ]
  ],
  'pntr' => [
    'name' => '작가명',
    'type' => 'CHAR',
    'length' => 20,
    'default' => '',
    'input' => [
      ['type'=>'text','attr'=>'required']
    ]
  ],
  'kind' => [
    'name' => '구분',
    'type' => 'CHAR',
    'length' => 4,
    'default' => '',
    'input' => [
      ['type'=>'radio','value'=>'국내','label'=>'국내'],
      ['type'=>'radio','value'=>'해외','label'=>'해외'],
    ]
  ],
  'comt' => [
    'name' => '작품해설',
    'type' => 'VARCHAR',
    'length' => 999,
    'default' => '',
    'input' => [
      // ['type'=>'text','attr'=>'required']
      ['type'=>'textarea', 'value'=>'', 'attr'=>'required']
    ]
  ],
);

$i = 0;
foreach ($tableData as $key => $value) {
  $keys[$i] = $key;
  $nameSpace[$key] = $value['name'];
  $i++;
} */