<?php // init.php
require_once 'includes/functions.php';

// DB
$dbconfig = json_decode(
  file_get_contents('./configs/dbconfig.json'), 
  true);
// console_log($dbconfig);
$host = $dbconfig['host'];
$user = $dbconfig['user'];
$pass = $dbconfig['pass'];
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, 'gyuholee');

// 글로벌 변수
$filename = '';
$post = '';

$filename = basename($_SERVER['PHP_SELF']);
$post = isset($_REQUEST['post'])?$_REQUEST['post']:'';

/** 기본 파라메터 변수
 * table=blog
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