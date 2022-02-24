<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

// 파일네임
$fileName = 'start.php';


/** 기본 파라메터 변수
 * table=cousmast
 *       traineee
 * action=view
 *        edit
 *        create
 * view&do=select
 *         manage
 * edit&do=update
 *         insert
 *         delete
 */
$table = 'cousmast';
$action = 'view';
$do = 'select';

// 기본 파라메터 리퀘스트 처리
$reqList = ['table', 'action', 'do'];
foreach ($reqList as $key) {
  if (isset($_REQUEST[$key]) && $_REQUEST[$key] != '') {
    $$key = $_REQUEST[$key];
  }
  console_log('$'.$key.': '.$$key);
}


// 테이블 기초 데이터
$tableList = [
  'cousmast' => '훈련과정',
  'traineee' => '훈련생'
];

// 테이블네임, 타이틀
$tableName = $tableList[$table];
$title = "$tableName 관리";



 /**
 * index.php
 * start.php
 * _create.php
 * _view.php
 * _edit.php
 * _add.php
 */

/**
 * template.php
 * _menutop.php
 * _menuleft.php
 * _menubottom.php
 */
