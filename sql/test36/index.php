<?php
require_once 'includes/init.php';

// 파일네임
$fileName = 'index.php';


// 테이블 존재 검사
foreach ($tableList as $key => $table) {
  if (!tableExist($key)) {
    // 하나라도 없으면 create 로
    header('Location:start.php?action=create');
    return false;
  }
}

// 모든 테이블이 존재하면 start 로
header('Location:start.php');

?>