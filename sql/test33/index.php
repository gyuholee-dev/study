<?php
require_once 'init.php';

// 변수
$table = 'dailyreport';
$fileName = 'index.php';

// 테이블 없으면 create
if (!tableExist($table)) {
  $msg = '테이블이 존재하지 않습니다';
  $url = 'create.php';
  sendMsg($msg, $url);
} else {
  echo "
    <script>
      location.href = 'view.php';
    </script>
  ";
}
