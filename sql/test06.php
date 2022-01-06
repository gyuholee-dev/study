<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

// php.ini 에서 date.timezone=Europe/Berlin
/* 
$date = DATE('Y-m-d');
echo '오늘날짜-1 = '.$date.'<br>';

$date = DATE('y-m-d');
echo '오늘날짜-2 = '.$date.'<br>';

$time = DATE('H:i:s');
echo '지금시간-1 : '.$time.'<br>';

$time = DATE('h:i:s');
echo '지금시간-1 : '.$time.'<br>';
 */
// test06.php : 차계부 관리 메인 화면
// test06_create.php
// test06_insert.php
// test06_select.php
// test06_update.php
// test06_delete.php
?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>차계부 관리</h3>
<hr>
<br><br>

<input type='button' value='테이블 생성' 
    onclick='location.href="test06_create.php"'>
<input type='button' value='자료 입력' 
    onclick='location.href="test06_insert.php"'>
<input type='button' value='자료 조회' 
    onclick='location.href="test06_select.php"'>
<input type='button' value='자료 수정' 
    onclick='location.href="test06_update.php"'>
<input type='button' value='자료 삭제' 
    onclick='location.href="test06_delete.php"'>

</html>